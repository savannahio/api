<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonalAccessTokenTest extends \Tests\TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Models\Users\PersonalAccessToken::toArray
     */
    public function testToArray(): void
    {
        $user = parent::createUser();
        $token = $user->createToken('asdfasdf');
        $array = $token->toArray();
        static::assertArrayHasKey('id', $array);
        static::assertArrayHasKey('name', $array);
        static::assertArrayHasKey('created_at', $array);
        static::assertArrayHasKey('updated_at', $array);
    }
}