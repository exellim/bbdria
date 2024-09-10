<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersBranch extends Model
{
    use HasFactory;
    protected $table = 'users_branches';

    protected $fillable = ['user_id', 'branch_id'];

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function branch(){
        return $this->belongsToMany(Branch::class);
    }
}
