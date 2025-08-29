<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestResourceSpeaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'rstbl_id',
        'gender',
        'agency',
        'division',
        'training_directory',
        'training_title',
        'venue',
        'date',
        'no_hours',
        'no_participants',
        'file'
    ];

    public function speaker()
    {
        return $this->belongsTo(Rstbl::class, 'rstbl_id');
    }
    public function accreditation()
    {
        return $this->hasOne(Accreditation::class, 'rstbl_id');
    }
}
