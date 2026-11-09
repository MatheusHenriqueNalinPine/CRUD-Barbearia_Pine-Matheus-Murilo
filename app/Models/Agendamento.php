<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = ['cliente_id', 'barbeiro_id', 'corte_id', 'data_hora', 'status'];

    public function cliente() {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function barbeiro() {
        return $this->belongsTo(User::class, 'barbeiro_id');
    }

    public function corte() {
        return $this->belongsTo(Corte::class, 'corte_id');
    }
}