<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatments extends Model
{
    use HasFactory;
    protected $table = 'treatments';


    protected $fillable = [
        'branch_id',
        'name',
        'price',
    ];

    // Relationship with Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Relationship with TreatmentComponent
    public function components()
    {
        return $this->hasMany(TreatmentsComponents::class, 'treatment_id');
    }

    // Relationship with AppointmentDetail
    public function appointmentsDetails()
    {
        return $this->hasMany(AppointmentsDetails::class, 'treatment_id');
    }
}
