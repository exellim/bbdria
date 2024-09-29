<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFinance extends Model
{
    use HasFactory;
    protected $table = "monthly_finances";
    protected $fillable = [
        'branch_id',
        'finance_date',
        'expenses',
        'profits'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
