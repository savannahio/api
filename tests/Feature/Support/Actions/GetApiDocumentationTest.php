<?php

declare(strict_types=1);

namespace Tests\Feature\Support\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetApiDocumentationTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::API_DOCUMENTATION->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Support\Actions\GetApiDocumentation::asController
     * @covers \App\Support\Actions\GetApiDocumentation::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $uri = route(name: RouteEnum::API_DOCUMENTATION->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Support\Actions\GetApiDocumentation::asController
     * @covers \App\Support\Actions\GetApiDocumentation::handle
     */
    public function testAccessDenied(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::API_DOCUMENTATION->value);
        $this->actingAs($user);
        $result = $this->get($uri);
        $result->assertStatus(403);
    }
}
