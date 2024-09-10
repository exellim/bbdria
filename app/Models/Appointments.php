<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'branch_id',
        'customer_id',
        'receipt_code',
        'appointment_date',
        'appointment_time',
        'dp',
        'status'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function details()
    {
        return $this->hasMany(AppointmentsDetails::class, 'receipt_code', 'receipt_code');
    }

}
