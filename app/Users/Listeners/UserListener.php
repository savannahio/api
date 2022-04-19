<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Actions\Payments\CreateCustomer;
use App\Actions\Payments\UpdateCustomer;
use App\Events\Users\ResetPasswordEvent;
use App\Events\Users\UserRegisteredEvent;
use App\Events\Users\UserUpdatedEmailEvent;
use App\Events\Users\UserUpdatedEvent;
use App\Notifications\Users\ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;

class UserListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function registered(UserRegisteredEvent $event): void
    {
        $user = $event->user;
        $user->sendEmailVerificationNotification();
        CreateCustomer::make()->handle($user);
    }

    public function userUpdated(UserUpdatedEvent $event): void
    {
        $user = $event->user;
        UpdateCustomer::make()->handle($user);
    }

    public function updatedEmail(UserUpdatedEmailEvent $event): void
    {
        $user = $event->user;
        $user->sendEmailVerificationNotification();
    }

    public function resetPassword(ResetPasswordEvent $event): void
    {
        $user = $event->user;
        $user->notify(new ResetPasswordNotification());
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(UserRegisteredEvent::class, [self::class, 'registered']);
        $events->listen(UserUpdatedEvent::class, [self::class, 'userUpdated']);
        $events->listen(ResetPasswordEvent::class, [self::class, 'resetPassword']);
        $events->listen(UserUpdatedEmailEvent::class, [self::class, 'updatedEmail']);
    }
}
