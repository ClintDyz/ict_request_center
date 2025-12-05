<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerItem extends Model
{
    protected $table = 'borrower_items';

    protected $fillable = [
        'borrower_request_id',
        'id_item_description',
        'quantity',
        'status',
        'actual_return_date'
    ];
    /**
     * Get the borrower request that owns this item
     */
    public function borrowerRequest()
    {
        return $this->belongsTo(BorrowerRequest::class, 'borrower_request_id');
    }

    /**
     * Get the equipment item description
     */
    public function itemDescription()
    {
        return $this->belongsTo(IctEquipment::class, 'id_item_description');
    }
}
