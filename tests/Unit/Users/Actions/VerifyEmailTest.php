<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class VerifyEmailTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\VerifyEmail::handle
     */
    public function testHandle(): void
    {
        $this->expectsEvents([Verified::class]);
        $user = parent::createUser();
        VerifyEmail::make()->handle($user);
    }

    /**
     * @covers \App\Users\Actions\VerifyEmail::handle
     */
    public function testAlreadyVerified(): void
    {
        $this->expectException(BadRequestHttpException::class);
        $user = parent::createUser();
        $user->markEmailAsVerified();
        VerifyEmail::make()->handle($user);
    }
}
