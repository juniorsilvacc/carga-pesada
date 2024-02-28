<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateNote extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cidade' => [
                'required',
                'min:2',
                'max:255',
            ],
            'estado' => [
                'required',
                'min:2',
                'max:255',
            ],
            'descricao' => [
                'min:3',
                'max:255',
            ],
            'valor' => [
                'required',
                'numeric',
                'min:0',
            ],
            'viagem_id' => [
                'required',
                'exists:travels,id',
            ],
        ];
    }
}
