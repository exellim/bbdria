<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplies extends Model
{
    use HasFactory;
    protected $table = 'supplies';
    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'hjl',
        'hpp',
        'image',
    ];


    // Relationship with AppointmentTreatment
    public function appointmentTreatments()
    {
        return $this->hasMany(AppointmentTreatments::class, 'supply_id');
    }

    // Relationship with Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Relationship with TreatmentComponent
    public function components()
    {
        return $this->hasMany(TreatmentsComponents::class, 'supplies_id');
    }

    // Relationship with SuppliesStock
    public function itemsStock()
    {
        return $this->hasMany(SuppliesStock::class,'supply_id');
    }

}
