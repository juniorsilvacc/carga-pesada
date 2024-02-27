<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Travel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'cidade_saida',
        'cidade_destino',
        'estado_saida',
        'estado_destino',
        'peso_carga',
        'data_viagem',
        'motorista_id',
        'caminhao_id',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }
}
