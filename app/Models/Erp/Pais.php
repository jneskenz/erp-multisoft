<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';

    protected $fillable = [
        'descripcion',
        'alias',
        'moneda',
        'simbolo',
        'estado',
    ];

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'pais_id');
    }   
}
