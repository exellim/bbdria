<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';

    protected $fillable = ['abbreviation', 'name', 'address', 'mobile'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_branches');
    }

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }

    // Relationship with the Item model
    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supplies::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatments::class);
    }

    public function customers()
    {
        return $this->hasMany(Customers::class);
    }

    public function suppliesIn()
    {
        return $this->hasMany(SuppliesIn::class);
    }

    public function suppliesOut()
    {
        return $this->hasMany(SuppliesOut::class);
    }

    public function itemsIn()
    {
        return $this->hasMany(ItemsIn::class);
    }

    public function itemsOut()
    {
        return $this->hasMany(ItemsOut::class);
    }

    public function appointments()
    {
        return $this->hasMany(appointments::class);
    }
}
