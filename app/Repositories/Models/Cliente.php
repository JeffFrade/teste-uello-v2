<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';
    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
        'cpf'
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'cpf', 'cpf');
    }
}
