<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class formApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dataForm;

    public function __construct($dataForm)
    {
        $this->dataBap = $dataForm;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
