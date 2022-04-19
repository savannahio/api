<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\PersonalAccessTokens;

use App\Auth\Actions\CreatePersonalAccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\NewAccessToken;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreatePersonalAccessTokenTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Auth\Actions\CreatePersonalAccessToken::handle
     */
    public function testHandle(): void
    {
        $name = 'asdfas';
        $user = parent::createUser();
        $new_access_token = CreatePersonalAccessToken::make()->handle($user, $name);
        static::assertInstanceOf(NewAccessToken::class, $new_access_token);
        static::assertSame($new_access_token->accessToken->name, $name);
    }

    /**
     * @covers \App\Auth\Actions\CreatePersonalAccessToken::handle
     */
    public function testEmptyTokenName(): void
    {
        $name = '';
        $user = parent::createUser();
        $new_access_token = CreatePersonalAccessToken::make()->handle($user, $name);
        static::assertInstanceOf(NewAccessToken::class, $new_access_token);
        static::assertSame($new_access_token->accessToken->name, $name);
    }
}
