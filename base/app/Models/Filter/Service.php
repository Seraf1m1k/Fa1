<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $fillable = [
        'services',
    ];
    public $timestamps = false;

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_services', 'service_id', 'company_id');
    }
}
