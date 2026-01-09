<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsLetter extends Model
{
    use HasFactory;

    protected $fillable = ['rstbl_id', 'rs_letter'];

    public function speaker()
    {
        return $this->belongsTo(Rstbl::class, 'rstbl_id');
    }
}
