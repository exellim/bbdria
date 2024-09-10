<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';

    protected $fillable = [
        'category_id',
        'branch_id',
        'name',
        'descriptions',
        'expiry_date',
        'hjl',
        'hpp',
        'image',
    ];

    // Relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    // Relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function itemsStock()
    {
        return $this->hasMany(ItemsStock::class, 'item_id');
    }

}
