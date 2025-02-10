<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = 'office';

    protected $fillable =[
        'office_organization', 'position', 'office_address', 'office_building_no','barangay', 'municipality', 'province', 'zip_code', 'tel_no', 'cell_no', 'fax_no'
    ];


    public function employees()
    {
        return $this->hasMany(Rstbl::class, 'id');
    }
}
