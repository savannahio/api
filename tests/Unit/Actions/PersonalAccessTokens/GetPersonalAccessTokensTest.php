<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\PersonalAccessTokens;

use App\Actions\PersonalAccessTokens\CreatePersonalAccessToken;
use App\Actions\PersonalAccessTokens\GetPersonalAccessTokens;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetPersonalAccessTokensTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\PersonalAccessTokens\GetPersonalAccessTokens::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        CreatePersonalAccessToken::make()->handle($user, 'asdfasdf');
        $result = GetPersonalAccessTokens::make()->handle($user);
        static::assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
