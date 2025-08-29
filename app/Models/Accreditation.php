<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rstbl_id',
        'field_of_expertise',
        'training_title_rs',
        'education',
        'work',
        'seminar',
        'experience',
        'award',
        'total',
        'status',
        'created_by',
        'updated_by'
    ];

    public function speaker()
    {
        return $this->belongsTo(Rstbl::class, 'rstbl_id');
    }
    // app/Models/Rstbl.php

        public function expertis()
        {
            return $this->hasMany(Expertis::class, 'rs_id');
        }

}
