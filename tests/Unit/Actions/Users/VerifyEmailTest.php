<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\VerifyEmail;
use App\Models\Users\User;
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
     * @covers \App\Actions\Users\VerifyEmail::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        $user = VerifyEmail::make()->handle($user);
        $this->assertInstanceOf(User::class, $user);
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
