<?php

namespace App\Livewire\Erp;

use App\Models\Erp\Articulo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticuloForm extends Component
{
    use WithFileUploads;

    // Propiedades del artículo
    public $articuloId;
    public $codigo;
    public $nombre;
    public $descripcion;
    public $marca;
    public $modelo;
    public $unidad_medida = 'UND';
    public $precio_costo = 0;
    public $precio_venta = 0;
    public $stock_minimo = 0;
    public $stock_actual = 0;
    public $stock_maximo = 0;
    public $ubicacion;
    public $imagen;
    public $imagen_actual;
    public $estado = true;
    public $inventariable = true;
    public $vendible = true;
    public $comprable = true;
    
    // Especificaciones como array
    public $especificaciones = [];
    public $nueva_especificacion_clave = '';
    public $nueva_especificacion_valor = '';
    
    // Control del formulario
    public $modo = 'create'; // create, edit, view
    public $mostrar_imagen_actual = false;

    protected $rules = [
        'codigo' => 'nullable|string|max:50',
        'nombre' => 'required|string|max:200',
        'descripcion' => 'nullable|string|max:1000',
        'marca' => 'nullable|string|max:100',
        'modelo' => 'nullable|string|max:100',
        'unidad_medida' => 'required|string|max:20',
        'precio_costo' => 'required|numeric|min:0|max:999999.99',
        'precio_venta' => 'required|numeric|min:0|max:999999.99',
        'stock_minimo' => 'required|integer|min:0',
        'stock_actual' => 'required|integer|min:0',
        'stock_maximo' => 'required|integer|min:0',
        'ubicacion' => 'nullable|string|max:100',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'estado' => 'boolean',
        'inventariable' => 'boolean',
        'vendible' => 'boolean',
        'comprable' => 'boolean',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre del artículo es obligatorio.',
        'nombre.max' => 'El nombre no debe exceder 200 caracteres.',
        'unidad_medida.required' => 'La unidad de medida es obligatoria.',
        'precio_costo.required' => 'El precio de costo es obligatorio.',
        'precio_costo.numeric' => 'El precio de costo debe ser un número.',
        'precio_venta.required' => 'El precio de venta es obligatorio.',
        'precio_venta.numeric' => 'El precio de venta debe ser un número.',
        'stock_minimo.required' => 'El stock mínimo es obligatorio.',
        'stock_actual.required' => 'El stock actual es obligatorio.',
        'stock_maximo.required' => 'El stock máximo es obligatorio.',
        'imagen.image' => 'El archivo debe ser una imagen.',
        'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o webp.',
        'imagen.max' => 'La imagen no debe exceder 2MB.',
    ];

    public function mount($articulo = null, $modo = 'create')
    {
        $this->modo = $modo;
        
        if ($articulo) {
            $this->articuloId = $articulo->id;
            $this->codigo = $articulo->codigo;
            $this->nombre = $articulo->nombre;
            $this->descripcion = $articulo->descripcion;
            $this->marca = $articulo->marca;
            $this->modelo = $articulo->modelo;
            $this->unidad_medida = $articulo->unidad_medida;
            $this->precio_costo = $articulo->precio_costo;
            $this->precio_venta = $articulo->precio_venta;
            $this->stock_minimo = $articulo->stock_minimo;
            $this->stock_actual = $articulo->stock_actual;
            $this->stock_maximo = $articulo->stock_maximo;
            $this->ubicacion = $articulo->ubicacion;
            $this->imagen_actual = $articulo->imagen;
            $this->estado = $articulo->estado;
            $this->inventariable = $articulo->inventariable;
            $this->vendible = $articulo->vendible;
            $this->comprable = $articulo->comprable;
            $this->especificaciones = $articulo->especificaciones ?? [];
            $this->mostrar_imagen_actual = !empty($articulo->imagen);
        }
    }

    public function generarCodigo()
    {
        if (empty($this->codigo)) {
            do {
                $codigo = 'ART-' . Str::upper(Str::random(6));
            } while (Articulo::where('codigo', $codigo)->exists());
            
            $this->codigo = $codigo;
        }
    }

    public function agregarEspecificacion()
    {
        if (!empty($this->nueva_especificacion_clave) && !empty($this->nueva_especificacion_valor)) {
            $this->especificaciones[$this->nueva_especificacion_clave] = $this->nueva_especificacion_valor;
            $this->nueva_especificacion_clave = '';
            $this->nueva_especificacion_valor = '';
        }
    }

    public function eliminarEspecificacion($clave)
    {
        unset($this->especificaciones[$clave]);
    }

    public function calcularMargen()
    {
        if ($this->precio_costo > 0) {
            return round((($this->precio_venta - $this->precio_costo) / $this->precio_costo) * 100, 2);
        }
        return 0;
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'codigo' => $this->codigo ?: $this->generarCodigoUnico(),
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'unidad_medida' => $this->unidad_medida,
                'precio_costo' => $this->precio_costo,
                'precio_venta' => $this->precio_venta,
                'stock_minimo' => $this->stock_minimo,
                'stock_actual' => $this->stock_actual,
                'stock_maximo' => $this->stock_maximo,
                'ubicacion' => $this->ubicacion,
                'estado' => $this->estado,
                'inventariable' => $this->inventariable,
                'vendible' => $this->vendible,
                'comprable' => $this->comprable,
                'especificaciones' => empty($this->especificaciones) ? null : $this->especificaciones,
            ];

            // Manejar imagen
            if ($this->imagen) {
                $nombreArchivo = time() . '_' . Str::slug(pathinfo($this->imagen->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $this->imagen->getClientOriginalExtension();
                $data['imagen'] = $this->imagen->storeAs('articulos', $nombreArchivo, 'public');
                
                // Eliminar imagen anterior si existe
                if ($this->imagen_actual && $this->modo === 'edit') {
                    Storage::disk('public')->delete($this->imagen_actual);
                }
            }

            if ($this->modo === 'create') {
                Articulo::create($data);
                $this->dispatch('show-alert', [
                    'type' => 'success',
                    'message' => 'Artículo creado exitosamente.'
                ]);
                return redirect()->route('articulos.index');
            } else {
                $articulo = Articulo::findOrFail($this->articuloId);
                $articulo->update($data);
                $this->dispatch('show-alert', [
                    'type' => 'success',
                    'message' => 'Artículo actualizado exitosamente.'
                ]);
                return redirect()->route('articulos.index');
            }

        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Error al guardar el artículo: ' . $e->getMessage()
            ]);
        }
    }

    private function generarCodigoUnico()
    {
        do {
            $codigo = 'ART-' . Str::upper(Str::random(6));
        } while (Articulo::where('codigo', $codigo)->exists());
        
        return $codigo;
    }

    public function render()
    {
        return view('livewire.erp.articulo-form');
    }
}
