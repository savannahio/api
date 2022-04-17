<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\PersonalAccessTokens;

use App\Actions\PersonalAccessTokens\CreatePersonalAccessToken;
use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\NewAccessToken;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetPersonalAccessTokensTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::asController
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $result = $this->postJson(route(RouteEnum::ACCESS_TOKENS_CREATE->value), ['name' => 'asdfasdf']);
        $result->assertStatus(201);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::rules
     */
    public function testNameIsNotLongEnough(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $result = $this->postJson(route(RouteEnum::ACCESS_TOKENS_CREATE->value), ['name' => 'a']);
        $result->assertStatus(422);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::rules
     */
    public function testNameMissing(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $result = $this->postJson(route(RouteEnum::ACCESS_TOKENS_CREATE->value));
        $result->assertStatus(422);
    }
}
