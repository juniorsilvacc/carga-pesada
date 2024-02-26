<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'superUser' => $this->superuser ? true : false,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
