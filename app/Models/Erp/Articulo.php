<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Articulo extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'articulos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'marca',
        'modelo',
        'unidad_medida',
        'precio_costo',
        'precio_venta',
        'stock_minimo',
        'stock_actual',
        'stock_maximo',
        'ubicacion',
        'imagen',
        'especificaciones',
        'estado',
        'inventariable',
        'vendible',
        'comprable',
        'categoria_id',
        'proveedor_id'
    ];

    protected $casts = [
        'precio_costo' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'stock_minimo' => 'integer',
        'stock_actual' => 'integer',
        'stock_maximo' => 'integer',
        'estado' => 'boolean',
        'inventariable' => 'boolean',
        'vendible' => 'boolean',
        'comprable' => 'boolean',
        'especificaciones' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Activity Log Configuration
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeInventariables($query)
    {
        return $query->where('inventariable', true);
    }

    public function scopeVendibles($query)
    {
        return $query->where('vendible', true);
    }

    public function scopeComprables($query)
    {
        return $query->where('comprable', true);
    }

    public function scopeBajoStock($query)
    {
        return $query->whereRaw('stock_actual <= stock_minimo');
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return "{$this->codigo} - {$this->nombre}";
    }

    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }

    public function getEstadoStockAttribute()
    {
        if ($this->stock_actual <= $this->stock_minimo) {
            return 'bajo';
        } elseif ($this->stock_actual >= $this->stock_maximo) {
            return 'alto';
        }
        return 'normal';
    }

    public function getMargenGananciaAttribute()
    {
        if ($this->precio_costo > 0) {
            return (($this->precio_venta - $this->precio_costo) / $this->precio_costo) * 100;
        }
        return 0;
    }

    // Relaciones (para futuras implementaciones)
    // public function categoria()
    // {
    //     return $this->belongsTo(Categoria::class, 'categoria_id');
    // }

    // public function proveedor()
    // {
    //     return $this->belongsTo(Proveedor::class, 'proveedor_id');
    // }
}
