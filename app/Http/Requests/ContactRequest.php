<?php

namespace App\Http\Requests;

use App\Rules\toUpperCase;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //si todos estan autorizados o no
        return true; //false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => ['required', new toUpperCase],
            'email' => 'required|email',
            'mensaje' => 'required|min:5|integer'
        ];
    }
}
