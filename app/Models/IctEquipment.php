<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IctEquipment extends Model {
    use HasFactory;
    protected $table = 'ict_equipment';
    protected $fillable = ['item_description','quantity'];

   /**
     * Get all borrower items for this equipment
     */
    public function borrowerItems()
    {
        return $this->hasMany(BorrowerItem::class, 'id_item_description');
    }

    /**
     * Old relationship - REMOVE THIS if it exists
     * public function borrowRequests()
     */
}
