<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertis extends Model
{
    use HasFactory;

    protected $fillable = ['rs_id', 'expertis'];

        public function rstbl()
        {
            return $this->belongsTo(Rstbl::class, 'rs_id', 'id');
        }
}
