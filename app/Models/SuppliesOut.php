<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliesOut extends Model
{
    use HasFactory;
    protected $table = 'supplies_out';
    protected $fillable = [
        'branch_id',
        'receipt_code',
        'date',
        'description',
        'total_price',
    ];

}
