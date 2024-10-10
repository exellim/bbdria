<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliesStock extends Model
{
    use HasFactory;
    protected $table = 'supplies_stocks';

    protected $fillable = [
        'supply_id',
        'qty',
        'units',
        'capacity',
        'reminder',
    ];

    // Relationship with Supplies
    public function supply()
    {
        return $this->belongsTo(Supplies::class);
    }
}
