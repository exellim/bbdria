<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'id',
        'branch_id',
        'name',
        'phone',
        'address',
        'image',
        'gender',
        'medical_informations',
    ];
    // Relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function galleries()
    {
        return $this->hasMany(CustomersGallery::class, 'customer_id');
    }


    // Relationship with the Appointment model
    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }
}
