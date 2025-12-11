<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationAverage extends Model
{
    use HasFactory;

      protected $fillable = [
        'rstbl_id',
        'field_of_expertise',
        'education',
        'work',
        'seminar',
        'experience',
        'award',
        'total',
    ];

    // relationship with speaker (assuming rstbl_id → rstbls.id)
    public function speaker()
    {
        return $this->belongsTo(Rstbl::class, 'rstbl_id', 'id');
    }

        public function rawAccreditations()
    {
        return $this->hasMany(Accreditation::class, 'rstbl_id', 'rstbl_id');
    }


}
