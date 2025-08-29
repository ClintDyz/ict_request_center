<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsTraining extends Model
{
    use HasFactory;

    protected $table = 'rs_training';

    protected $fillable =[
        'rt_title', 'rt_venue', 'rt_date', 'rt_no_hours'
    ];

    public function rstbl()
    {
        return $this->belongsTo(Rstbl::class, 'rs_id');
    }
}
