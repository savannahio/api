<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\PersonalAccessTokens;

use App\Actions\PersonalAccessTokens\CreatePersonalAccessToken;
use App\Actions\PersonalAccessTokens\DeletePersonalAccessToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class DeletePersonalAccessTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\PersonalAccessTokens\DeletePersonalAccessToken::handle
     */
    public function testHandle(): void
    {
        $name = 'asdfas';
        $user = parent::createUser();
        $new_access_token = CreatePersonalAccessToken::make()->handle($user, $name);
        DeletePersonalAccessToken::make()->handle($user, $new_access_token->accessToken);
        $token_results = $user->tokens()->where('name', '=', $name)->count();
        static::assertSame(0, $token_results);
    }
}
