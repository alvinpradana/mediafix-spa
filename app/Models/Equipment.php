<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = [
        'user_id',
        'equipment_type',
        'equipment_name',
        'equipment_quantity',
        'equipment_condition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
