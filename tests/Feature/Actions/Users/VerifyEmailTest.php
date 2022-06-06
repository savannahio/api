<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\Support\Enum\RouteEnum;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class VerifyEmailTest extends FeatureTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\VerifyEmail::asController
     */
    public function testSuccessWithRedirect(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $uri = URL::temporarySignedroute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        $result = $this->get($uri);
        $result->assertStatus(302);
    }

    /**
     * @covers \App\Actions\Users\VerifyEmail::asController
     */
    public function testSuccessJson(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $uri = URL::temporarySignedroute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\VerifyEmail::asController
     */
    public function testAlreadyVerified(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $user->markEmailAsVerified();
        $this->actingAs($user);
        $uri = URL::temporarySignedroute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
        $result = $this->get($uri);
        $result->assertStatus(400);
    }

    /**
     * @covers \App\Actions\Users\VerifyEmail::asController
     */
    public function testValidationFailure(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::EMAIL_VERIFICATION->value, parameters: ['id' => 'asdfasdf', 'hash' => 'asdfasdf', 'expires' => 'asdf', 'signature' => 'asdf']);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }
}
