<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code','customer_id','service_id','package_id',
        'event_date','start_time','end_time','location','brief',
        'total_price','status'
    ];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function package() { return $this->belongsTo(Package::class); }
}
