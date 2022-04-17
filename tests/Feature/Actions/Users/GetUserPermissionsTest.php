<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\UpdateUser::asController
     */
    public function testSuccessfulApiCall(): void
    {
        $user = parent::createUser();
        $request = [
            'first_name' => 'first',
            'last_name' => 'last',
        ];
        $this->actingAs($user);
        $result = $this->putJson(route(RouteEnum::USERS_UPDATE->value, ['user' => $user->id]), $request);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'first_name', 'last_name', 'email',
        ]);
    }

    /**
     * @covers \App\Actions\Users\UpdateUser::asController
     * @covers \App\Actions\Users\UpdateUser::rules
     */
    public function testEmailValidation(): void
    {
        $user = parent::createUser();
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf',
        ];
        $this->actingAs($user);
        $result = $this->putJson(route(RouteEnum::USERS_UPDATE->value, ['user' => $user->id]), $request);
        $result->assertStatus(422);
        $result->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /**
     * @covers \App\Actions\Users\UpdateUser::asController
     * @covers \App\Actions\Users\UpdateUser::rules
     */
    public function testCannotUpdateOtherUsers(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asoweksd@asdflasd.com');
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf@asdfasdf.com',
        ];
        $this->actingAs($user_a);
        $result = $this->putJson(route(RouteEnum::USERS_UPDATE->value, ['user' => $user_b->id]), $request);
        $result->assertStatus(403);
    }

    /**
     * @covers \App\Actions\Users\UpdateUser::asController
     * @covers \App\Actions\Users\UpdateUser::rules
     */
    public function testCanUpdateOtherUsers(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USERS->value]);
        $user_b = parent::createUser(email: 'asoweksd@asdflasd.com');
        $request = [
            'first_name' => 'first',
            'email' => 'asdfasdf@asdfasdf.com',
        ];
        $this->actingAs($user_a);
        $result = $this->putJson(route(RouteEnum::USERS_UPDATE->value, ['user' => $user_b->id]), $request);
        $result->assertStatus(200);
    }

}
