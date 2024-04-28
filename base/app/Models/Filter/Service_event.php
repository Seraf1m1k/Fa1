<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_event extends Model
{
    use HasFactory;
    protected $table = 'service_events';
    protected $fillable = [
        'service_id',
        'event_id',
    ];
    public $timestamps = false;
}
