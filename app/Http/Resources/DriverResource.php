<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'data_nascimento' => date('d-m-Y', strtotime($this->data_nascimento)),
            'ativo' => $this->ativo ? true : false,
            'user_id' => $this->user_id,
        ];
    }
}
