<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'cidade',
        'estado',
        'descricao',
        'valor',
        'viagem_id',
    ];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'viagem_id');
    }
}
