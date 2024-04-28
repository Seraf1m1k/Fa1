<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_tag extends Model
{
    use HasFactory;
    protected $table = 'service_tags';
    protected $fillable = [
        'service_id',
        'tag_id',
    ];

    public $timestamps = false;
}
