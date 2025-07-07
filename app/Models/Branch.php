<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $table = 'branches';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'address', 'photo', 'status'];
    public $timestamps = true;
    public $incrementing = true;

    public function barbers(): HasMany
    {
        return $this->hasMany(Barber::class, 'branch_id', 'id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'branch_id', 'id');;
    }
}
