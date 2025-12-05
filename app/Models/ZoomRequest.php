<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZoomRequest extends Model {
    use HasFactory;
    protected $table = 'zoom_request';

    protected $fillable = [
        'f_name','l_name','m_name','start_date','start_time','end_date','end_time',
        'no_of_participants','id_position','id_division_unit','month','year', 'topic','status',
    ];

    public function position() { return $this->belongsTo(Position::class, 'id_position'); }

    public function divisionUnit() {
    return $this->belongsTo(DivisionUnit::class, 'id_division_unit');
}

}
