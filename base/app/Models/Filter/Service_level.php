<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_level extends Model
{
    use HasFactory;
    protected $table = 'service_levels';
    protected $fillable = [
        'level'
    ];
    public $timestamps = false;
}
