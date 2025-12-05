<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DostCalendar extends Model
{
    use HasFactory;
        protected $table = 'dost_calendars';
    protected $fillable = ['event_title','start_date','start_time','end_date','end_time'];
}
