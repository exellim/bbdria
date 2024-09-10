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

    // Relationship with AppointmentTreatment
    public function treatments()
    {
        return $this->hasMany(AppointmentTreatments::class, 'receipt_code', 'receipt_code');
    }

    public function details()
    {
        return $this->hasMany(AppointmentsDetails::class, 'receipt_code', 'receipt_code');
    }

}
