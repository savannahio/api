<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Auth;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResendVerificationEmailTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::EMAIL_VERIFICATION_RESEND->value);
        $result = $this->postJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::EMAIL_VERIFICATION_RESEND->value);
        $this->actingAs($user);
        $result = $this->postJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Auth\ResendVerificationEmail::asController
     * @covers \App\Actions\Auth\ResendVerificationEmail::handle
     */
    public function testSuccessEmailAlreadyVerified(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::EMAIL_VERIFICATION_RESEND->value);
        $user->markEmailAsVerified();
        $this->actingAs($user);
        $result = $this->postJson($uri);
        $result->assertStatus(400);
    }
}
