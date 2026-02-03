<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name','description','is_active'];

    public function packages() { return $this->hasMany(Package::class); }
    public function portfolios() { return $this->hasMany(Portfolio::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
}
