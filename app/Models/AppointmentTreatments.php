<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTreatments extends Model
{
    use HasFactory;
    protected $table = 'appointment_treatments';

    protected $fillable = [
        'receipt_code',
        'supply_id',
        'supply_qty',
    ];

    // Relationship with Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointments::class, 'receipt_code', 'receipt_code');
    }

    // Relationship with Supply
    public function supply()
    {
        return $this->belongsTo(Supplies::class, 'supply_id');
    }
}
