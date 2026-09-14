<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'locality_id',
        'address',
        'phone',
        'email',
        'lat',
        'lng',
        'is_active',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
