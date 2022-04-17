<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\GetAuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetAuthUserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\GetAuthUser::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        $result = GetAuthUser::make()->handle($user);
        $this->assertIsArray($result);
    }

}