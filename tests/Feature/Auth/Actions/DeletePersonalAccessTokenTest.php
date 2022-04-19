<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Actions;

use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class DeletePersonalAccessTokenTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::ACCESS_TOKENS_DELETE->value, parameters: ['personal_access_token' => 4]);
        $result = $this->deleteJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Auth\Actions\DeletePersonalAccessToken::asController
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $create_uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $this->actingAs($user);
        $create_result = $this->postJson($create_uri, ['name' => 'asdfasdf']);
        $id = $create_result->json('accessToken')['id'];
        $delete_uri = route(name: RouteEnum::ACCESS_TOKENS_DELETE->value, parameters: ['personal_access_token' => $id]);
        $result = $this->deleteJson($delete_uri);
        $result->assertStatus(204);
    }

    /**
     * @covers \App\Auth\Actions\DeletePersonalAccessToken::asController
     */
    public function testTokenNotFound(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ACCESS_TOKENS_DELETE->value, parameters: ['personal_access_token' => 4324]);
        $this->actingAs($user);
        $result = $this->deleteJson($uri);
        $result->assertStatus(404);
    }

    /**
     * @covers \App\Auth\Actions\DeletePersonalAccessToken::asController
     */
    public function testTokenDoesNotBelongToUser(): void
    {
        $user_a = parent::createUser();
        $create_uri = route(name: RouteEnum::ACCESS_TOKENS_CREATE->value);
        $this->actingAs($user_a);
        $create_result = $this->postJson($create_uri, ['name' => 'asdfasdf']);
        $id = $create_result->json('accessToken')['id'];
        $delete_uri = route(name: RouteEnum::ACCESS_TOKENS_DELETE->value, parameters: ['personal_access_token' => $id]);
        $user_b = parent::createUser(email: 'asdfasdfasdf@asdfasdf.com');
        $this->actingAs($user_b);
        $result = $this->deleteJson($delete_uri);
        $result->assertStatus(404);
    }
}
