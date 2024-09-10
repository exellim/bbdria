<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = ['id', 'branch_id', 'name'];

    // Relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Relationship with the Item model
    public function items()
    {
        // return $this->hasMany(Items::class);
        return $this->hasMany(Items::class, 'category_id');

    }
}
