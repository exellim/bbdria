<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentsDetails extends Model
{
    use HasFactory;
    protected $table = 'appointments_details';

    protected $fillable = ['receipt_code', 'treatment_id'];

    public function appointment()
    {
        return $this->belongsTo(Appointments::class, 'receipt_code', 'receipt_code');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatments::class);
    }
}
