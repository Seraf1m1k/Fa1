<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'level',
        'id_r',
        'OGRN',
        'city_id'
    ];
    protected $hidden = [
        'date',
        'city'
    ];
    public $timestamps = false;

    public function services()
    {
        return $this->belongsToMany(Service::class, 'company_services', 'company_id', 'service_id');
    }
}
