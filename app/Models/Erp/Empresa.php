<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Empresa extends Model
{
    
    use HasFactory, HasRoles;

    protected $table = 'empresas';

    protected $fillable = [
        'numerodocumento',
        'razon_social',
        'nombre_comercial',
        'direccion',
        'telefono',
        'correo',
        'avatar',
        'estado',
        'pais_id',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    


}
