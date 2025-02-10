<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsWorkExperience extends Model
{
    use HasFactory;

    protected $table = 'rs_work_experiences';

    protected $fillable =[
        'date_started', 'date_ended', 'name_company', 'address', 'division', 'position'
    ];


    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
