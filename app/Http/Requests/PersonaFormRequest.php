<?php

namespace LaSolucion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
       'nombre'=>'required|max:100',
        'documento'=>'required|max:9999999990',
        'direccion'=>'max:150',
        'telefono'=>'max:50',
        'email'=>'max:50',
        ];
    }
}
