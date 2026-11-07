<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'imagem',
        'preco',
        'quantidade',
    ];

    protected function casts(): array
    {
        return [
            'quantidade' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
