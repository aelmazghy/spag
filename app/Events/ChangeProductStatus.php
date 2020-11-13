<?php

namespace App\Events;

use App\product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeProductStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $product;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product =$product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
    {
        // This must always be an array. Since it will be parsed with json_encode()
        // data
        return [

            'product' => $this->product,
        ];
    }

    public function broadcastAs()
    {
        // event
        return 'productUpdated';
    }


    public function broadcastOn()
    {
      //  return new PrivateChannel('channel-name');
        // canal
        return new Channel('products');
    }
}
