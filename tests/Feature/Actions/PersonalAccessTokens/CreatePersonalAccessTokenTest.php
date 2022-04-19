<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\PersonalAccessTokens;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreatePersonalAccessTokenTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $result = $this->postJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::asController
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $this->actingAs($user);
        $result = $this->postJson($uri, ['name' => 'asdfasdf']);
        $result->assertStatus(201);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::rules
     */
    public function testNameIsNotLongEnough(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $this->actingAs($user);
        $result = $this->postJson($uri, ['name' => 'a']);
        $result->assertStatus(422);
    }

    /**
     * @covers \App\Actions\PersonalAccessTokens\CreatePersonalAccessToken::rules
     */
    public function testNameMissing(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $this->actingAs($user);
        $result = $this->postJson($uri);
        $result->assertStatus(422);
    }
}
