<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentsComponents extends Model
{
    use HasFactory;
    protected $table = 'treatments_components';

    protected $fillable = [
        'treatment_id',
        'supply_id',
        'qty',
    ];

    // Relationship with Treatment
    public function treatment()
    {
        return $this->belongsTo(Treatments::class, 'treatment_id');
    }

    // Relationship with Supplies
    public function supplies()
    {
        return $this->belongsTo(Supplies::class, 'supply_id');
    }
}



