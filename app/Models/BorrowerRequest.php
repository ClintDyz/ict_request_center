<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowerRequest extends Model
{
    protected $table = 'borrower_request';

    protected $fillable = [
        'f_name',
        'l_name',
        'm_name',
        'id_position',
        'id_division_unit',
        'date_borrowed',
        'date_return',
    ];

    /**
     * Get the position
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    /**
     * Get the division unit
     */
    public function divisionUnit()
    {
        return $this->belongsTo(DivisionUnit::class, 'id_division_unit');
    }

    /**
     * Get all borrowed items for this request
     */
    public function borrowerItems()
    {
        return $this->hasMany(BorrowerItem::class, 'borrower_request_id');
    }

    /**
     * REMOVE these old relationships if they exist:
     * public function itemDescription()
     * public function borrowRequests()
     */
}
