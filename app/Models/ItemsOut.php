<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsOut extends Model
{
    use HasFactory;
    protected $table = "items_out";
    protected $fillable = [
        'branch_id',
        'receipt_code',
        'date',
        'descriptions',
        'total_price',
    ];

     // Relationship with ItemsOutDetails
     public function details()
     {
         return $this->hasMany(ItemsOutDetails::class, 'receipt_code', 'receipt_code');
     }

     // Relationship with Branch
     public function branch()
     {
         return $this->belongsTo(Branch::class);
     }
}
