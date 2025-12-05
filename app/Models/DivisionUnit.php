<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DivisionUnit extends Model {
    use HasFactory;
    protected $table = 'division_unit';

    protected $fillable = ['division_unit'];
}
