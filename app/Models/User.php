<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    public function cortes()
    {
        return $this->hasMany(Corte::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function fornecedores()
    {
        return $this->hasMany(Fornecedor::class);
    }
}
