<?php

namespace App\Events;

use App\Models\Order;  // Importação correta do modelo Order
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    // Construtor do evento, que recebe o modelo Order
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Definir o canal em que o evento será transmitido
    public function broadcastOn()
    {
        return new Channel('orders');  // O canal pode ser 'orders' ou qualquer outro nome desejado
    }

    // Nome do evento no canal
    public function broadcastAs()
    {
        return 'OrderStatusUpdated';  // Nome do evento
    }
}
