<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsOutDetails extends Model
{
    use HasFactory;
    protected $table = "items_out_details";
    protected $fillable = [
        'receipt_code',
        'item_id',
        'qty',
        'price',
    ];

        // Relationship with ItemsOut
        public function itemsOut()
        {
            return $this->belongsTo(ItemsOut::class, 'receipt_code', 'receipt_code');
        }

        // Relationship with Item
        public function item()
        {
            return $this->belongsTo(Items::class, 'item_id');
        }
}
