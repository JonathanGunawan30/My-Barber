<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'name', 'email', 'password',
        'google_id', 'avatar', 'phone'
    ];

    protected $hidden = ['password'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class, 'customer_id', 'id');
    }
}
