<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsEducational extends Model
{
    use HasFactory;

    protected $table = 'rs_educational';

        // Add fields to the fillable array
        protected $fillable = [
            'level', 'school', 'from_year', 'to_year', 'year_graduated', 'awards'
        ];


    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
