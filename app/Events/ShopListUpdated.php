<?php

namespace App\Events;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\ShopList;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShopListUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $list;
    public function __construct(ShopList $list)
    {
        $this->list = $list;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('bad-words');
    }

    public function broadcastWith(){
        return [
            'list' => $this->list,
            'products' => $this->list->products,
            'shops' => $this->list->group->shops,
            'categories' => Category::all(),
            'exampleProducts' => CategoryProduct::all(),
            ];
    }

}
