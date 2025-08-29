<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsPublication extends Model
{
    use HasFactory;

    protected $table = 'rs_publications';
    protected $fillable = [
        'p_title',
        'p_nature',
        'p_date',
        'p_venue',
    ];
    public function publications() {
        return $this->hasMany(Publication::class);
    }

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
