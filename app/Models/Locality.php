<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'state',
        'pincode',
        'is_active',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
