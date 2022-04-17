<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\PersonalAccessTokens;

use App\Actions\PersonalAccessTokens\CreatePersonalAccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\NewAccessToken;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreatePersonalAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::handle
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
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::handle
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
