<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Auth\Actions\ResendVerificationEmail;
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
     * @covers \App\Auth\Actions\ResendVerificationEmail::asController
     * @covers \App\Auth\Actions\ResendVerificationEmail::handle
     */
    public function testSuccess(): void
    {
        Notification::fake();
        $user = parent::createUser();
        ResendVerificationEmail::make()->handle($user);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Auth\Actions\ResendVerificationEmail::asController
     * @covers \App\Auth\Actions\ResendVerificationEmail::handle
     */
    public function testSuccessEmailAlreadyVerified(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $user = parent::createUser();
        $user->markEmailAsVerified();
        ResendVerificationEmail::make()->handle($user);
    }
}
