<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $guarded = ['id'];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
