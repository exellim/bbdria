<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsStock extends Model
{
    use HasFactory;
    protected $table = 'items_stocks';

    protected $fillable = [
        'item_id',
        'qty',
    ];

    // Relationship with the Item model
    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
