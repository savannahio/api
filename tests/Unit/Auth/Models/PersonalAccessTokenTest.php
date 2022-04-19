<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class PersonalAccessTokenTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Auth\Models\PersonalAccessToken::toArray
     */
    public function testToArray(): void
    {
        $user = parent::createUser();
        $token = $user->createToken('asdfasdf');
        $array = $token->accessToken->toArray();
        static::assertArrayHasKey('id', $array);
        static::assertArrayHasKey('name', $array);
        static::assertArrayHasKey('created_at', $array);
        static::assertArrayHasKey('updated_at', $array);
    }
}
