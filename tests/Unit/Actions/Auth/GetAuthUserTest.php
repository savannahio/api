<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\GetAuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetAuthUserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\GetAuthUser::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        $result = GetAuthUser::make()->handle($user);
        static::assertIsArray($result);
    }
}
