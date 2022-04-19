<?php

declare(strict_types=1);

namespace Tests\Feature\Users\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateUserTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_UPDATE->value, parameters: ['user' => 23423]);
        $result = $this->putJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Users\Actions\UpdateUser::asController
     */
    public function testSuccessfulApiCall(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_UPDATE->value, parameters: ['user' => $user->id]);
        $request = [
            'first_name' => 'first',
            'last_name' => 'last',
        ];
        $this->actingAs($user);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'first_name', 'last_name', 'email',
        ]);
    }

    /**
     * @covers \App\Users\Actions\UpdateUser::asController
     * @covers \App\Users\Actions\UpdateUser::rules
     */
    public function testEmailValidation(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_UPDATE->value, parameters: ['user' => $user->id]);
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf',
        ];
        $this->actingAs($user);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(422);
        $result->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /**
     * @covers \App\Users\Actions\UpdateUser::asController
     * @covers \App\Users\Actions\UpdateUser::rules
     */
    public function testCannotUpdateOtherUsers(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asoweksd@asdflasd.com');
        $uri = route(name: RouteEnum::USERS_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf@asdfasdf.com',
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(403);
    }

    /**
     * @covers \App\Users\Actions\UpdateUser::asController
     * @covers \App\Users\Actions\UpdateUser::rules
     */
    public function testCanUpdateOtherUsers(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USERS->value]);
        $user_b = parent::createUser(email: 'asoweksd@asdflasd.com');
        $uri = route(name: RouteEnum::USERS_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf@asdfasdf.com',
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
    }
}
