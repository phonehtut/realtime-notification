<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SampleNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting on channel: notification-channel', ['data' => $this->data]);
        return new Channel('notification-channel');
    }

    public function broadcastAs()
    {
        return 'sample.notification';
    }

    public function broadcastWith()
    {
        Log::info('Broadcasting with payload:', ['message' => $this->data]);
        return ['message' => $this->data];
    }
}
