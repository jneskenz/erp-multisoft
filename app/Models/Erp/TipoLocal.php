<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoLocal extends Model
{
    use HasFactory;

    protected $table = 'tipo_locales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // Relación con locales
    public function locales()
    {
        return $this->hasMany(Local::class, 'tipo_local_id');
    }
}
