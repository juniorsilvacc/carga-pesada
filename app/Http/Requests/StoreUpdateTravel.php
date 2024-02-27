<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTravel extends FormRequest
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
            'cidade_saida' => [
                'required',
                'min:3',
                'max:255',
            ],
            'estado_saida' => [
                'required',
                'min:2',
                'max:255',
            ],
            'estado_destino' => [
                'required',
                'min:2',
                'max:255',
            ],
            'cidade_destino' => [
                'required',
                'min:3',
                'max:255',
            ],
            'data_viagem' => [
                'required',
                'date',
            ],
            'peso_carga' => [
                'required',
                'min:0',
            ],
            'motorista_id' => [
                'required',
                'exists:drivers,id',
            ],
            'caminhao_id' => [
                'required',
                'exists:trucks,id',
            ],
        ];
    }
}
