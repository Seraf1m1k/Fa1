<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'type',
        'district',
    ];
    protected $hidden = [
        'population'
    ];
    public $timestamps = false;
}
