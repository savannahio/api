<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\PersonalAccessTokens;

use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetPersonalAccessTokensTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::ACCESS_TOKENS_LIST->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Auth\Actions\GetPersonalAccessTokens::asController
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_LIST->value, parameters: ['page' => 1]);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Auth\Actions\GetPersonalAccessTokens::rules
     */
    public function testValidationErrors(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_LIST->value, parameters: ['page' => 'asdfasdf']);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(422);
    }
}
