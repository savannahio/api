<?php

namespace Tests\Unit\Actions\PersonalAccessTokens;

use App\Actions\Payments\CreateCustomer;
use App\Actions\PersonalAccessTokens\CreatePersonalAccessToken;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\NewAccessToken;
use Tests\TestCase;

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
        $this->assertInstanceOf(NewAccessToken::class, $new_access_token);
        $this->assertEquals($new_access_token->accessToken->name, $name);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::handle
     */
    public function testEmptyTokenName(): void
    {
        $name = '';
        $user = parent::createUser();
        $new_access_token = CreatePersonalAccessToken::make()->handle($user, $name);
        $this->assertInstanceOf(NewAccessToken::class, $new_access_token);
        $this->assertEquals($new_access_token->accessToken->name, $name);
    }
}