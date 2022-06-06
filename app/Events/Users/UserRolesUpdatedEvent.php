<?php

declare(strict_types=1);

namespace App\Events\Users;

use App\Models\Users\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRolesUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public User $user)
    {
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('users.'.$this->user->id);
    }

    public function broadcastAs(): string
    {
        return 'UserRolesUpdatedEvent';
    }

}
