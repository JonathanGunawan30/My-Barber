<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hairstyle extends Model
{
    protected $table = 'hairstyles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = ['name', 'photo', 'is_featured', 'description'];

}
