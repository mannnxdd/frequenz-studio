<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['service_id','name','price','down_payment','duration_minutes','is_active'];

    public function service() { return $this->belongsTo(Service::class); }
}
