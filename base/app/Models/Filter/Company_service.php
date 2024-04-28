<?php

namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_service extends Model
{
    use HasFactory;

    protected $table = 'company_services';
    protected $fillable = [
        'id',
        'service_id',
        'level_id',
        'company_id'
    ];
    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
