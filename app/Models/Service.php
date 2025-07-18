<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['name', 'price', 'duration', 'photo', 'description'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_id', 'id');
    }
}
