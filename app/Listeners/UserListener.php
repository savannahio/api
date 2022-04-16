<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Actions\Payments\CreateCustomer;
use App\Events\Users\ResetPasswordEvent;
use App\Events\Users\UserRegisteredEvent;
use App\Events\Users\UserUpdatedEmailEvent;
use App\Models\Users\User;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;

class UserListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function registered(UserRegisteredEvent $event): void
    {
        $user = $event->user;
        $this->handleEmailUpdate($user);
        CreateCustomer::make()->handle($user);
    }

    public function updatedEmail(UserUpdatedEmailEvent $event): void
    {
        $user = $event->user;
        $this->handleEmailUpdate($user);
    }

    public function resetPassword(ResetPasswordEvent $event): void
    {
        $user = $event->user;
        $user->notify(new ResetPasswordNotification());
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(UserRegisteredEvent::class, [self::class, 'registered']);
        $events->listen(ResetPasswordEvent::class, [self::class, 'resetPassword']);
        $events->listen(UserUpdatedEmailEvent::class, [self::class, 'updatedEmail']);
    }

    private function handleEmailUpdate(User $user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
