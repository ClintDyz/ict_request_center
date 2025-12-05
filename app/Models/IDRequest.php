<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IDRequest extends Model
{
    use HasFactory;

    protected $table = 'id_request';

    protected $fillable = [
        'f_name','l_name','m_name','nick_name','birthdate','blood_type',
        'id_position','id_division_unit','emergency_contact_name',
        'emergency_contact_address','emergency_contact_number', 'status', 'image', 'signature', 'valid_until'
    ];

    protected $casts = [
    'valid_until' => 'date',
];


    public function position() {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function divisionUnit() {
        return $this->belongsTo(DivisionUnit::class, 'id_division_unit');
    }
}
