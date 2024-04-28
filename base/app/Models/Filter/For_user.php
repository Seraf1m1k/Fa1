<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class For_user extends Model
{
    use HasFactory;
    protected $table = 'for_users';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
}
