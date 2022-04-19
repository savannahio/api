<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class DeleteUserTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_DELETE->value, parameters: ['user' => 234]);
        $result = $this->deleteJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Users\Actions\DeleteUser::asController
     */
    public function testCannotDeleteOwnUser(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::DELETE_USERS->value]);
        $uri = route(name: RouteEnum::USERS_DELETE->value, parameters: ['user' => $user->id]);
        $this->actingAs($user);
        $result = $this->deleteJson($uri);
        $result->assertStatus(400);
    }

    /**
     * @covers \App\Users\Actions\DeleteUser::asController
     */
    public function testCanDeleteOtherUsers(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::DELETE_USERS->value]);
        $user_b = parent::createSecondUser();
        $uri = route(name: RouteEnum::USERS_DELETE->value, parameters: ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->deleteJson($uri);
        $result->assertStatus(204);
    }

    /**
     * @covers \App\Users\Actions\DeleteUser::asController
     */
    public function testCannotDeleteUsers(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        $uri = route(name: RouteEnum::USERS_DELETE->value, parameters: ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->deleteJson($uri);
        $result->assertStatus(403);
    }
}
