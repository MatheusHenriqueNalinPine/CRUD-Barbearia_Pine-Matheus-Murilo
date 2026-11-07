<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    public const TIPOS_CABELO = [
        'liso' => 'Liso',
        'ondulado' => 'Ondulado',
        'cacheado' => 'Cacheado',
        'crespo' => 'Crespo',
    ];

    protected $fillable = [
        'user_id',
        'corte_favorito_id',
        'nome',
        'tipo_cabelo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function corteFavorito(): BelongsTo
    {
        return $this->belongsTo(Corte::class, 'corte_favorito_id')->withTrashed();
    }
}
