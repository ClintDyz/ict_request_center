<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsExperienceTrainer extends Model
{
    use HasFactory;

    protected $table = 'rs_experience_trainer';
    protected $fillable = [
        'title',
        'date_venue',
        'no_hours'
    ];

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
