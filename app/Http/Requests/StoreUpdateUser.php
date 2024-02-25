<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUser extends FormRequest
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
            'nome' => [
                'required',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                "unique:users,email,{$this->id},id",
            ],
            'cpf' => [
                'required',
                'size:11',
                "unique:users,cpf,{$this->id},id",
            ],
            'rg' => [
                'required',
                'size:8',
                "unique:users,rg,{$this->id},id",
            ],
            'data_nascimento' => [
                'required',
                'date',
            ],
            'password' => [
                'required',
                'min: 6',
            ],
        ];
    }
}
