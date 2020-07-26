<?php

namespace LaSolucion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'nombre'=>'required|max:50',
        'tiempoelaboracion'=>'required|numeric',
        'descripcion'=>'max:150',
        'valor'=>'required|numeric|min:1',
        'idcategoria'=>'required|numeric',
        'descripcion'=>'max:150',
        'imagen'=>'mimes:jpeg,bmp,png',
        'costo' =>'numeric|min:1'
        ];
    }
}
