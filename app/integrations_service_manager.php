<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class integrations_service_manager extends Model
{
    protected $table = 'integrations_service_manager';
    protected $primaryKey = 'cerrado_por';
    // protected $primaryKey = ['cerrado_por', 'carga'];
    protected $fillable = [
        'cerrado_por',
        'cumplidos',
        'cerrados',
        'cumplimiento',
        'carga',
        'productividad'
    ];

    public function scopeUsername($query, $username){
        if($username){
            return $query->orWhere('cerrado_por','LIKE',"%$username%");
        }
            
        

    }
}
