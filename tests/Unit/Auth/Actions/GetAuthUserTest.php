<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Actions;

use App\Auth\Actions\GetAuthUser;
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
     * @covers \App\Auth\Actions\GetAuthUser::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        $result = GetAuthUser::make()->handle($user);
        static::assertIsArray($result);
    }
}
