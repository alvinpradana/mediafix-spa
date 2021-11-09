<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOut extends Model
{
    use HasFactory;
    
    protected $table = 'cash_outs';
    protected $fillable = [
        'user_id',
        'cash_description',
        'cash_date',
        'cash_amount',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
