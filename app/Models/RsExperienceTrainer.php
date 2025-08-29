<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsExperienceTrainer extends Model
{
    use HasFactory;

    protected $table = 'rs_experience_trainer';

    protected $fillable =[
        'rst_title', 'rst_venue', 'rst_date', 'rst_no_hours'
    ];

    // public function RsExperienceTrainer() {
    //     return $this->hasMany(Training::class);
    // }

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
