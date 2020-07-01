<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';
    protected $primaryKey = 'endereco_id';
    protected $fillable = [
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'latitude',
        'longitude',
        'cpf'
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'cpf', 'cpf');
    }
}
