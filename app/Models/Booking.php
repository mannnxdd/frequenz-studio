<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'customer_id',
        'service_id',
        'package_id',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'brief',
        'total_price',
        'status',
    ];
    protected $casts = [
        'event_date' => 'date',
    ];
    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */
    const STATUS_PENDING     = 'pending';
    const STATUS_CONFIRMED   = 'confirmed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE        = 'done';
    const STATUS_CANCELLED   = 'cancelled';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_DONE,
        self::STATUS_CANCELLED,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isPending()     { return $this->status === self::STATUS_PENDING; }
    public function isConfirmed()   { return $this->status === self::STATUS_CONFIRMED; }
    public function isInProgress()  { return $this->status === self::STATUS_IN_PROGRESS; }
    public function isDone()        { return $this->status === self::STATUS_DONE; }
    public function isCancelled()   { return $this->status === self::STATUS_CANCELLED; }

    /*
    |--------------------------------------------------------------------------
    | Accessors (UI Friendly)
    |--------------------------------------------------------------------------
    */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING     => 'Pending',
            self::STATUS_CONFIRMED   => 'Confirmed',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_DONE        => 'Done',
            self::STATUS_CANCELLED   => 'Cancelled',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING     => 'yellow',
            self::STATUS_CONFIRMED   => 'green',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_DONE        => 'gray',
            self::STATUS_CANCELLED   => 'red',
        };
    }
}
