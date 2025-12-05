<?php

namespace App\Http\Controllers;

use App\Models\BorrowerRequest;
use App\Models\BorrowerItem;
use App\Models\Position;
use App\Models\DivisionUnit;
use App\Models\IctEquipment;
use Illuminate\Http\Request;
use DB;

class BorrowerRequestController extends Controller
{
    public function index()
    {
        $borrowers = BorrowerRequest::with(['position', 'divisionUnit', 'borrowerItems.itemDescription'])->get();
        $positions = Position::all();
        $divisions = DivisionUnit::all();

        // Only count borrowed (not returned) items
        $items = IctEquipment::withCount(['borrowerItems as borrowed_qty' => function ($query) {
            $query->where('status', 'borrowed') // Only count unreturned items
                ->select(DB::raw('coalesce(sum(quantity),0)'));
        }])->get();

        foreach ($items as $item) {
            $item->available = $item->quantity - $item->borrowed_qty;
        }

        return view('borrower_request.index', compact('borrowers', 'positions', 'divisions', 'items'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string|max:100',
            'l_name' => 'required|string|max:100',
            'm_name' => 'nullable|string|max:100',
            'id_position' => 'required|exists:position,id',
            'id_division_unit' => 'required|exists:division_unit,id',
            'date_borrowed' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_item_description' => 'required|exists:ict_equipment,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Create borrower request
            $borrower = BorrowerRequest::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'm_name' => $request->m_name,
                'id_position' => $request->id_position,
                'id_division_unit' => $request->id_division_unit,
                'date_borrowed' => $request->date_borrowed,
                'date_return' => $request->date_return,
            ]);

            // Validate and create borrowed items
            foreach ($request->items as $item) {
                // Check available stock
                $equipment = IctEquipment::withCount(['borrowerItems as borrowed_qty' => function ($query) {
                    $query->select(DB::raw('coalesce(sum(quantity),0)'));
                }])->findOrFail($item['id_item_description']);

                $available = $equipment->quantity - $equipment->borrowed_qty;

                if ($item['quantity'] > $available) {
                    throw new \Exception("Insufficient stock for {$equipment->item_description}. Available: {$available}");
                }

                BorrowerItem::create([
                    'borrower_request_id' => $borrower->id,
                    'id_item_description' => $item['id_item_description'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Borrower request created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $borrower = BorrowerRequest::findOrFail($id);

        $request->validate([
            'f_name' => 'required|string|max:100',
            'l_name' => 'required|string|max:100',
            'm_name' => 'nullable|string|max:100',
            'id_position' => 'required|exists:position,id',
            'id_division_unit' => 'required|exists:division_unit,id',
            'date_borrowed' => 'required|date',
            'date_return' => 'required|date|after_or_equal:date_borrowed',
            'items' => 'required|array|min:1',
            'items.*.id_item_description' => 'required|exists:ict_equipment,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Update borrower info
            $borrower->update([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'm_name' => $request->m_name,
                'id_position' => $request->id_position,
                'id_division_unit' => $request->id_division_unit,
                'date_borrowed' => $request->date_borrowed,
                'date_return' => $request->date_return,
            ]);

            // Delete old items
            $borrower->borrowerItems()->delete();

            // Validate and create new items
            foreach ($request->items as $item) {
                $equipment = IctEquipment::withCount(['borrowerItems as borrowed_qty' => function ($query) use ($id) {
                    $query->where('borrower_request_id', '!=', $id)
                          ->select(DB::raw('coalesce(sum(quantity),0)'));
                }])->findOrFail($item['id_item_description']);

                $available = $equipment->quantity - $equipment->borrowed_qty;

                if ($item['quantity'] > $available) {
                    throw new \Exception("Insufficient stock for {$equipment->item_description}. Available: {$available}");
                }

                BorrowerItem::create([
                    'borrower_request_id' => $borrower->id,
                    'id_item_description' => $item['id_item_description'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Borrower request updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $borrower = BorrowerRequest::findOrFail($id);
            $borrower->borrowerItems()->delete(); // Delete related items
            $borrower->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Borrower request deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete borrower request.');
        }
    }
    // Add this new method for returning items
public function returnItems(Request $request, $id)
{
    $request->validate([
        'item_ids' => 'required|array',
        'item_ids.*' => 'required|exists:borrower_items,id',
    ]);

    DB::beginTransaction();
    try {
        foreach ($request->item_ids as $itemId) {
            BorrowerItem::where('id', $itemId)
                ->where('borrower_request_id', $id)
                ->update([
                    'status' => 'returned',
                    'actual_return_date' => now()->toDateString()
                ]);
        }

        DB::commit();
        return redirect()->back()->with('success', 'Items returned successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to return items.');
    }
}
}
