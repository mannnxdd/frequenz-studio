<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['service_id','title','description','project_date','is_published'];

    public function service() { return $this->belongsTo(\App\Models\Service::class); }
public function media() { return $this->hasMany(\App\Models\PortfolioMedia::class); }
}
