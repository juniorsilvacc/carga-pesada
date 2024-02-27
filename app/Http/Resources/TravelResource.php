<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
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
            'cidade_saida' => $this->cidade_saida,
            'cidade_destino' => $this->cidade_destino,
            'estado_saida' => $this->estado_saida,
            'estado_destino' => $this->estado_destino,
            'peso_carga' => $this->peso_carga,
            'data_viagem' => $this->data_viagem,
            'motorista_id' => $this->motorista_id,
            'caminhao_id' => $this->caminhao_id,
        ];
    }
}
