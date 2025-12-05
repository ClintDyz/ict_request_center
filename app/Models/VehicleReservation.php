<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleReservation extends Model
{
    use HasFactory;

    protected $table = 'vehicle_reservations';

    protected $fillable = [
        'requestors',
        'l_name',
        'f_name',
        'm_name',
        'id_division_unit',
        'id_position',
        'destination',
        'departure_date',
        'departure_time',
        'return_date',
        'return_time',
        'vehicle_name',
        'plate_number',
        'driver_name',
        'purpose',
        'status',
        'attachment', // ✅ Add this
    ];

    protected $casts = [
        'requestors' => 'array',
    ];

    // Relationships
    public function division()
    {
        return $this->belongsTo(DivisionUnit::class, 'id_division_unit');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }
}
