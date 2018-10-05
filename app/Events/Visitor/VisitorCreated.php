<?php
/**
 * Created by PhpStorm.
 * User: Imbalance
 * Date: 03.10.2018
 * Time: 11:34
 */

namespace App\Events\Visitor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;


/**
 * Class VisitorCreated
 * @package App\Events
 */
class VisitorCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $visitorId;
    public $visitorIp;


    public function __construct(string $visitorId, $visitorIp)
    {
        $this->visitorId = $visitorId;
        $this->visitorIp = $visitorIp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}