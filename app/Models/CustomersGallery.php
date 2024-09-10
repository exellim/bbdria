<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersGallery extends Model
{
    use HasFactory;
    protected $table = 'customers_galleries';


    protected $fillable = [
        'customer_id', // Not 'customers_id'
        'name',
        'image',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
