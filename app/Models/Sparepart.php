<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;
    
    protected $table = 'spareparts';
    protected $fillable = [
        'user_id',
        'sparepart_type',
        'sparepart_name',
        'sparepart_quantity',
        'sparepart_price'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
