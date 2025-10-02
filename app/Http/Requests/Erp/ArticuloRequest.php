<?php

namespace App\Http\Requests\Erp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticuloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $articuloId = $this->route('articulo') ? $this->route('articulo')->id : null;

        return [
            'codigo' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('articulos', 'codigo')->ignore($articuloId),
            ],
            'nombre' => [
                'required',
                'string',
                'max:200',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'marca' => [
                'nullable',
                'string',
                'max:100',
            ],
            'modelo' => [
                'nullable',
                'string',
                'max:100',
            ],
            'unidad_medida' => [
                'required',
                'string',
                'max:20',
            ],
            'precio_costo' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'precio_venta' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'stock_minimo' => [
                'required',
                'integer',
                'min:0',
            ],
            'stock_actual' => [
                'required',
                'integer',
                'min:0',
            ],
            'stock_maximo' => [
                'required',
                'integer',
                'min:0',
            ],
            'ubicacion' => [
                'nullable',
                'string',
                'max:100',
            ],
            'imagen' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048', // 2MB
            ],
            'estado' => [
                'sometimes',
                'boolean',
            ],
            'inventariable' => [
                'sometimes',
                'boolean',
            ],
            'vendible' => [
                'sometimes',
                'boolean',
            ],
            'comprable' => [
                'sometimes',
                'boolean',
            ],
            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categorias,id',
            ],
            'proveedor_id' => [
                'nullable',
                'integer',
                'exists:proveedores,id',
            ],
            'especificaciones_json' => [
                'nullable',
                'json',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'codigo.unique' => 'El código ya está en uso por otro artículo.',
            'codigo.max' => 'El código no debe exceder :max caracteres.',
            'nombre.required' => 'El nombre del artículo es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder :max caracteres.',
            'descripcion.max' => 'La descripción no debe exceder :max caracteres.',
            'marca.max' => 'La marca no debe exceder :max caracteres.',
            'modelo.max' => 'El modelo no debe exceder :max caracteres.',
            'unidad_medida.required' => 'La unidad de medida es obligatoria.',
            'unidad_medida.max' => 'La unidad de medida no debe exceder :max caracteres.',
            'precio_costo.required' => 'El precio de costo es obligatorio.',
            'precio_costo.numeric' => 'El precio de costo debe ser un número.',
            'precio_costo.min' => 'El precio de costo no puede ser negativo.',
            'precio_costo.max' => 'El precio de costo no debe exceder :max.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'precio_venta.min' => 'El precio de venta no puede ser negativo.',
            'precio_venta.max' => 'El precio de venta no debe exceder :max.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'stock_minimo.integer' => 'El stock mínimo debe ser un número entero.',
            'stock_minimo.min' => 'El stock mínimo no puede ser negativo.',
            'stock_actual.required' => 'El stock actual es obligatorio.',
            'stock_actual.integer' => 'El stock actual debe ser un número entero.',
            'stock_actual.min' => 'El stock actual no puede ser negativo.',
            'stock_maximo.required' => 'El stock máximo es obligatorio.',
            'stock_maximo.integer' => 'El stock máximo debe ser un número entero.',
            'stock_maximo.min' => 'El stock máximo no puede ser negativo.',
            'ubicacion.max' => 'La ubicación no debe exceder :max caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o webp.',
            'imagen.max' => 'La imagen no debe exceder 2MB.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
            'inventariable.boolean' => 'El campo inventariable debe ser verdadero o falso.',
            'vendible.boolean' => 'El campo vendible debe ser verdadero o falso.',
            'comprable.boolean' => 'El campo comprable debe ser verdadero o falso.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'proveedor_id.exists' => 'El proveedor seleccionado no es válido.',
            'especificaciones_json.json' => 'Las especificaciones deben tener un formato JSON válido.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convertir checkboxes a boolean
        $this->merge([
            'estado' => $this->boolean('estado'),
            'inventariable' => $this->boolean('inventariable'),
            'vendible' => $this->boolean('vendible'),
            'comprable' => $this->boolean('comprable'),
        ]);
    }
}
