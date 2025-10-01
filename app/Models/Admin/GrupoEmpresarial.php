<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GrupoEmpresarial extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'grupo_empresarials';

    protected $fillable = [
        'user_uuid',
        'nombre',
        'descripcion',
        'codigo',
        'pais_origen',
        'telefono',
        'email',
        'sitio_web',
        'direccion_matriz',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relación con empresas
    public function empresas()
    {
        return $this->hasMany(\App\Models\Erp\Empresa::class, 'grupo_empresarial_id');
    }

    // Scope para grupos activos
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    // Accessor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->codigo ? "({$this->codigo}) {$this->nombre}" : $this->nombre;
    }
}
