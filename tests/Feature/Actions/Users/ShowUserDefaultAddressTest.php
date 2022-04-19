<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\Support\Address;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShowUserDefaultAddressTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => 2343]);
        $result = $this->putJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Users\ShowUserDefaultAddress::asController
     */
    public function testCanViewOwnEmptyDefaultAddress(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_SHOW->value, parameters: ['user' => $user->id]);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
        $result->assertJsonStructure([], $result->json());
    }

    /**
     * @covers \App\Actions\Users\ShowUserDefaultAddress::asController
     */
    public function testCanViewOwnDefaultAddress(): void
    {
        $user = parent::createUser();
        $create_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user->id]);
        $show_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_SHOW->value, parameters: ['user' => $user->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user);
        $this->putJson($create_uri, $request);
        $result = $this->getJson($show_uri);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'name', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'is_default',
        ], $result->json());
        static::assertTrue($result->json('is_default'));
    }

    /**
     * @covers \App\Actions\Users\ShowUserDefaultAddress::asController
     */
    public function testCanViewOtherUsersDefaultAddress(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdfasdf@asdfasdf.com', permissions: [PermissionEnum::VIEW_USER_ADDRESSES->value]);
        $create_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user_a->id]);
        $show_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_SHOW->value, parameters: ['user' => $user_a->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user_a);
        $this->putJson($create_uri, $request);

        $this->actingAs($user_b);
        $result = $this->getJson($show_uri);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'name', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'is_default',
        ], $result->json());
        static::assertTrue($result->json('is_default'));
    }

    /**
     * @covers \App\Actions\Users\ShowUserDefaultAddress::asController
     */
    public function testCannotViewOtherUsersDefaultAddress(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdfasdf@asdfasdf.com');
        $create_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value, parameters: ['user' => $user_a->id]);
        $show_uri = route(name: RouteEnum::USERS_DEFAULT_ADDRESS_SHOW->value, parameters: ['user' => $user_a->id]);
        $request = Address::factory()->make()->toArray();
        $this->actingAs($user_a);
        $this->putJson($create_uri, $request);

        $this->actingAs($user_b);
        $result = $this->getJson($show_uri);
        $result->assertStatus(403);
    }
}
