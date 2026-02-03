<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioMedia extends Model
{
    protected $table = 'portfolio_media';
    protected $fillable = ['portfolio_id','media_type','url'];
}
