<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'travels';

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

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'viagem_id');
    }

    public function calculateSubTotal(): float
    {
        $subTotal = 0;

        foreach ($this->notes as $note) {
            $subTotal += $note->valor;
        }

        return $subTotal;
    }
}
