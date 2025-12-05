@extends('layouts.admin')

@section('content')

<style>
    select option:disabled {
        color: #6c757d;
        font-style: italic;
    }
    .item-row {
        position: relative;
        transition: all 0.3s ease;
    }
    .item-row:hover {
        background-color: #f8f9fa !important;
    }
</style>

<div class="d-flex align-items-center mb-3">
    <h1 class="h3 mb-0 me-auto">Borrower Requests</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBorrowerModal">
        <i class="fa-solid fa-circle-plus me-1"></i> New Borrower
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-header bg-success text-white">
        <i class="fa fa-table me-2"></i> Borrower List
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Division/Unit</th>
                        <th>Items</th>
                        <th>Date Borrowed</th>
                        <th>Date Return</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowers as $borrower)
                    <tr>
                        <td>{{ $borrower->l_name }}, {{ $borrower->f_name }} {{ $borrower->m_name }}</td>
                        <td>{{ $borrower->position->position ?? '—' }}</td>
                        <td>{{ $borrower->divisionUnit->division_unit ?? '—' }}</td>
                        <td>
                            @if($borrower->borrowerItems->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($borrower->borrowerItems as $item)
                                <li>
                                    <strong>{{ $item->itemDescription->item_description ?? '—' }}</strong>
                                    <span class="badge bg-primary">Qty: {{ $item->quantity }}</span>
                                    @if(isset($item->status))
                                        @if($item->status === 'returned')
                                            <span class="badge bg-success">✓ Returned</span>
                                        @else
                                            <span class="badge bg-warning">Borrowed</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Borrowed</span>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <span class="text-muted">No items</span>
                            @endif
                        </td>
                        <td>{{ $borrower->date_borrowed }}</td>
                        <td>{{ $borrower->date_return }}</td>
                        <td>
                            @php
                                $hasBorrowedItems = $borrower->borrowerItems->filter(function($item) {
                                    return !isset($item->status) || $item->status === 'borrowed';
                                })->count() > 0;
                            @endphp

                            <button class="btn btn-success btn-sm mb-1" data-bs-toggle="modal"
                                data-bs-target="#returnItemsModal">
                                <i class="fa fa-undo"></i> Return
                            </button>

                            {{-- @if($hasBorrowedItems)
                            <button class="btn btn-success btn-sm mb-1" data-bs-toggle="modal"
                                data-bs-target="#returnItemsModal-{{ $borrower->id }}">
                                <i class="fa fa-undo"></i> Return
                            </button>
                            @endif --}}

                            <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal"
                                data-bs-target="#editBorrowerModal-{{ $borrower->id }}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal"
                                data-bs-target="#deleteBorrowerModal-{{ $borrower->id }}">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>

                    {{-- ================= RETURN ITEMS MODAL ================= --}}
                    <div class="modal fade" id="returnItemsModal-{{ $borrower->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('borrower_request.return_items', $borrower->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">Return Items</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Select items to return for <strong>{{ $borrower->f_name }} {{ $borrower->l_name }}</strong>:</p>

                                        @php
                                            $borrowedItems = $borrower->borrowerItems->filter(function($item) {
                                                return !isset($item->status) || $item->status === 'borrowed';
                                            });
                                        @endphp

                                        @if($borrowedItems->count() > 0)
                                            @foreach($borrowedItems as $item)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                       name="item_ids[]" value="{{ $item->id }}"
                                                       id="return-item-{{ $item->id }}">
                                                <label class="form-check-label" for="return-item-{{ $item->id }}">
                                                    {{ $item->itemDescription->item_description ?? '—' }}
                                                    <span class="badge bg-primary">Qty: {{ $item->quantity }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No borrowed items to return.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        @if($borrowedItems->count() > 0)
                                            <button type="submit" class="btn btn-success">Return Selected Items</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ================= EDIT MODAL ================= --}}
                    <div class="modal fade" id="editBorrowerModal-{{ $borrower->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <form action="{{ route('borrower_request.update', $borrower->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Edit Borrower Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <h6 class="mb-3 text-info">Borrower Information</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name="f_name" class="form-control"
                                                    value="{{ $borrower->f_name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Middle Name</label>
                                                <input type="text" name="m_name" class="form-control"
                                                    value="{{ $borrower->m_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="l_name" class="form-control"
                                                    value="{{ $borrower->l_name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Position</label>
                                                <select name="id_position" class="form-select" required>
                                                    @foreach($positions as $pos)
                                                    <option value="{{ $pos->id }}" {{ $borrower->id_position == $pos->id ? 'selected' : '' }}>
                                                        {{ $pos->position }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Division/Unit</label>
                                                <select name="id_division_unit" class="form-select" required>
                                                    @foreach($divisions as $div)
                                                    <option value="{{ $div->id }}" {{ $borrower->id_division_unit == $div->id ? 'selected' : '' }}>
                                                        {{ $div->division_unit }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date Borrowed</label>
                                                <input type="date" name="date_borrowed" class="form-control"
                                                    value="{{ $borrower->date_borrowed }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date Return</label>
                                                <input type="date" name="date_return" class="form-control"
                                                    value="{{ $borrower->date_return }}" required>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-info">Items to Borrow</h6>
                                            <button type="button" class="btn btn-sm btn-success add-item-btn-edit"
                                                data-borrower-id="{{ $borrower->id }}">
                                                <i class="fa fa-plus me-1"></i> Add Item
                                            </button>
                                        </div>

                                        <div id="itemsContainer-edit-{{ $borrower->id }}">
                                            @foreach($borrower->borrowerItems as $index => $borrowerItem)
                                            <div class="item-row border rounded p-3 mb-3 bg-light">
                                                <div class="row g-3">
                                                    <div class="col-md-9">
                                                        <label class="form-label">Item Description</label>
                                                        <select name="items[{{ $index }}][id_item_description]"
                                                            class="form-select item-select" required>
                                                            <option value="">-- Select Item --</option>
                                                            @foreach($items as $item)
                                                            @php
                                                            $effective_available = ($borrowerItem->id_item_description == $item->id)
                                                            ? $item->available + $borrowerItem->quantity
                                                            : $item->available;
                                                            $should_be_disabled = ($effective_available <= 0 && $borrowerItem->id_item_description != $item->id);
                                                            @endphp
                                                            <option value="{{ $item->id }}"
                                                                data-qty="{{ $effective_available }}"
                                                                {{ $borrowerItem->id_item_description == $item->id ? 'selected' : '' }}
                                                                {{ $should_be_disabled ? 'disabled' : '' }}>
                                                                {{ $item->item_description }} (Available: {{ $effective_available }})
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number"
                                                            name="items[{{ $index }}][quantity]"
                                                            class="form-control quantity-input"
                                                            value="{{ $borrowerItem->quantity }}" min="1" required>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-item-btn">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ================= DELETE MODAL ================= --}}
                    <div class="modal fade" id="deleteBorrowerModal-{{ $borrower->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('borrower_request.destroy', $borrower->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Delete Borrower Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete
                                            <strong>{{ $borrower->f_name }} {{ $borrower->l_name }}</strong>?</p>
                                        <p class="text-danger"><strong>This will also delete all associated
                                                items.</strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hidden template for dynamic items --}}
<template id="itemRowTemplate">
    <div class="item-row border rounded p-3 mb-3 bg-light">
        <div class="row g-3">
            <div class="col-md-9">
                <label class="form-label">Item Description</label>
                <select name="items[REPLACE_INDEX][id_item_description]" class="form-select item-select" required>
                    <option value="">-- Select Item --</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" data-qty="{{ $item->available }}"
                        {{ $item->available <= 0 ? 'disabled' : '' }}>
                        {{ $item->item_description }} (Available: {{ $item->available }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Quantity</label>
                <input type="number" name="items[REPLACE_INDEX][quantity]" class="form-control quantity-input" min="1"
                    required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

{{-- CREATE MODAL --}}
<div class="modal fade" id="createBorrowerModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('borrower_request.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">New Borrower Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h6 class="mb-3 text-primary">Borrower Information</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input type="text" name="f_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="m_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="l_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Position</label>
                            <select name="id_position" class="form-select" required>
                                <option value="">-- Select Position --</option>
                                @foreach($positions as $pos)
                                <option value="{{ $pos->id }}">{{ $pos->position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Division/Unit</label>
                            <select name="id_division_unit" class="form-select" required>
                                <option value="">-- Select Division/Unit --</option>
                                @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->division_unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date Borrowed</label>
                            <input type="date" name="date_borrowed" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date Return (Optioonal)</label>
                            <input type="date" name="date_return" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 text-primary">Items to Borrow</h6>
                        <button type="button" class="btn btn-sm btn-success" id="addItemBtn">
                            <i class="fa fa-plus me-1"></i> Add Item
                        </button>
                    </div>

                    <div id="itemsContainer">
                        <div class="item-row border rounded p-3 mb-3 bg-light">
                            <div class="row g-3">
                                <div class="col-md-9">
                                    <label class="form-label">Item Description</label>
                                    <select name="items[0][id_item_description]" class="form-select item-select"
                                        required>
                                        <option value="">-- Select Item --</option>
                                        @foreach($items as $item)
                                        <option value="{{ $item->id }}" data-qty="{{ $item->available }}"
                                            {{ $item->available <= 0 ? 'disabled' : '' }}>
                                            {{ $item->item_description }} (Available: {{ $item->available }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="items[0][quantity]" class="form-control quantity-input"
                                        min="1" required>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-item-btn" disabled>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const template = document.querySelector('#itemRowTemplate').innerHTML;

    function newRow(index) {
        const temp = document.createElement('div');
        temp.innerHTML = template.replace(/REPLACE_INDEX/g, index);
        const row = temp.firstElementChild;
        row.querySelector('.remove-item-btn').disabled = false;
        return row;
    }

    function reindex(container) {
        container.querySelectorAll('.item-row').forEach((row, i) => {
            row.querySelectorAll('select, input').forEach(el => {
                const name = el.getAttribute('name');
                if (name) el.name = name.replace(/\[\d+\]/, `[${i}]`);
            });
        });
    }

    function toggleRemove(container) {
        const rows = container.querySelectorAll('.item-row');
        rows.forEach(btnRow => {
            const btn = btnRow.querySelector('.remove-item-btn');
            btn.disabled = rows.length <= 1;
        });
    }

    // CREATE MODAL
    const addBtn = document.querySelector('#addItemBtn');
    const createContainer = document.querySelector('#itemsContainer');

    addBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const index = createContainer.querySelectorAll('.item-row').length;
        createContainer.appendChild(newRow(index));
        toggleRemove(createContainer);
    });

    createContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            e.preventDefault();
            const row = e.target.closest('.item-row');
            row.remove();
            reindex(createContainer);
            toggleRemove(createContainer);
        }
    });

    // EDIT MODALS
    document.querySelectorAll('.add-item-btn-edit').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = btn.dataset.borrowerId;
            const container = document.querySelector(`#itemsContainer-edit-${id}`);
            const index = container.querySelectorAll('.item-row').length;
            container.appendChild(newRow(index));
            toggleRemove(container);
        });
    });

    document.querySelectorAll('[id^="itemsContainer-edit-"]').forEach(container => {
        container.addEventListener('click', e => {
            if (e.target.closest('.remove-item-btn')) {
                e.preventDefault();
                e.target.closest('.item-row').remove();
                reindex(container);
                toggleRemove(container);
            }
        });
    });
});
</script>

@endsection
