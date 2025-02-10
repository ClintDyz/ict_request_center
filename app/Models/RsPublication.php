<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsPublication extends Model
{
    use HasFactory;

    protected $table = 'rs_publications';
    protected $fillable = [
        'title',
        'nature',
        'date_venue',
    ];

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
