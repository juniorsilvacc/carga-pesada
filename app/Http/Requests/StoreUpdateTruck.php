<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTruck extends FormRequest
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
            'placa' => [
                'required',
                'size:7',
                "unique:trucks,placa,{$this->id},id",
            ],
            'renavan' => [
                'required',
                'size:11',
                "unique:trucks,renavan,{$this->id},id",
            ],
            'antt' => [
                'size:11',
            ],
            'modalidade' => [
                'required',
                'min:3',
                'max:255',
            ],
        ];
    }
}
