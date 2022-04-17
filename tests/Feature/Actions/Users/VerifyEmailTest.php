<?php

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\TestCase;

final class VerifyEmailTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\VerifyEmail::handle
     */
    public function testHandle(): void
    {
        $this->expectsEvents([Verified::class]);
        $user = parent::createUser();
        VerifyEmail::make()->handle($user);
    }

    /**
     * @covers \App\Actions\Users\VerifyEmail::handle
     */
    public function testAlreadyVerified(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $user = parent::createUser();
        $user->markEmailAsVerified();
        VerifyEmail::make()->handle($user);
    }
}