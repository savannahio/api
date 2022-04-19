<?php

declare(strict_types=1);

namespace App\Users\Listeners;

use App\Payments\Actions\CreateCustomer;
use App\Payments\Actions\UpdateCustomer;
use App\Users\Events\ResetPasswordEvent;
use App\Users\Events\UserRegisteredEvent;
use App\Users\Events\UserUpdatedEmailEvent;
use App\Users\Events\UserUpdatedEvent;
use App\Users\Notifications\ResetPasswordNotification;
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
