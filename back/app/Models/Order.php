<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Propriedades e métodos do modelo Order
    protected $table = 'orders';  // Caso você tenha uma tabela 'orders'

    protected $fillable = [
        'status',  // Adicione outros campos conforme necessário
        'user_id', // Exemplo: chave estrangeira do usuário
        // Outros campos do seu modelo
    ];

    // Aqui você pode definir as relações, se houver, como por exemplo:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
