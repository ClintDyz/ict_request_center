<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsReferencesTraining extends Model
{
    use HasFactory;

    protected $table = 'rs_references_trainings';

    protected $fillable = [
        'name_agency',         
        'address',
        'contact_person',
        'position',
        'tel_no',
        'cell_no',
        'fax_no'
    ];

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
