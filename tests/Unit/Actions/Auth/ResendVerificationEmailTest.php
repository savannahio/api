<?php

namespace Tests\Feature\Actions\Auth;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ResendVerificationEmailTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $result = $this->postJson(route(RouteEnum::EMAIL_VERIFICATION_RESEND->value));
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     */
    public function testSuccessEmailAlreadyVerified(): void
    {
        $user = parent::createUser();
        $user->markEmailAsVerified();
        $this->actingAs($user);
        $result = $this->postJson(route(RouteEnum::EMAIL_VERIFICATION_RESEND->value));
        $result->assertStatus(400);
    }
}