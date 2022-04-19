<?php

declare(strict_types=1);

namespace Tests\Feature\Users\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Locations\Models\Address;
use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateUserDefaultAddressTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => 2343]);
        $result = $this->putJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Locations\Actions\CreateAddress::rules
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::asController
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::rules
     */
    public function testCreateInitialDefaultAddress(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'name', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'is_default',
        ], $result->json());
        static::assertTrue($result->json('is_default'));
    }

    /**
     * @covers \App\Locations\Actions\CreateAddress::rules
     * @covers \App\Locations\Actions\UpdateAddress::rules
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::asController
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::rules
     */
    public function testUpdateExistingDefaultAddress(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user);
        $this->putJson($uri, $request);

        $request = Address::factory()->make()->toArray();
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'name', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'is_default',
        ], $result->json());
        static::assertTrue($result->json('is_default'));
    }

    /**
     * @covers \App\Locations\Actions\CreateAddress::rules
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::asController
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::rules
     */
    public function testValidationErrors(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user->id]);
        $this->actingAs($user);
        $result = $this->putJson($uri, []);
        $result->assertStatus(422);
        $result->assertJsonStructure([
            'message',
            'errors' => [
                'name', 'street1', 'city', 'state', 'zip', 'country',
            ],
        ], $result->json());
    }

    /**
     * @covers \App\Locations\Actions\UpdateAddress::rules
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::asController
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::rules
     */
    public function testCanUpdateOtherUsersDefaultAddress(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdfasdf@asdfasdf.com', permissions: [PermissionEnum::UPDATE_USER_ADDRESSES->value]);
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user_a->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user_a);
        $this->putJson($uri, $request);

        $this->actingAs($user_b);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::asController
     */
    public function testCannotUpdateOtherUsersDefaultAddress(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdfasdf@asdfasdf.com');
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user_a->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user_a);
        $this->putJson($uri, $request);

        $this->actingAs($user_b);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(403);
    }
}
