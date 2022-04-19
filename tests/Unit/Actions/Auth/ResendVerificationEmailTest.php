<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ResendVerificationEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResendVerificationEmailTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     */
    public function testSuccess(): void
    {
        Notification::fake();
        $user = parent::createUser();
        ResendVerificationEmail::make()->handle($user);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     */
    public function testSuccessEmailAlreadyVerified(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $user = parent::createUser();
        $user->markEmailAsVerified();
        ResendVerificationEmail::make()->handle($user);
    }
}
