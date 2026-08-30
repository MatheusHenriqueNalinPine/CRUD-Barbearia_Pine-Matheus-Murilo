<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corte extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome_corte',
        'horario',
        'imagem',
        'preco',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}