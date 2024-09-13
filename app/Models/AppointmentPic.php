<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentPic extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'receipt_code',
        'users_id',
    ];

    // Relationship with Appointment
    public function appointment()
    {
        return $this->belongsTo(Appointments::class, 'receipt_code', 'receipt_code');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
