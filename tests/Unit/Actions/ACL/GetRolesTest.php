<?php

namespace Tests\Unit\Actions\ACL;

use App\Actions\ACL\GetPermissions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

final class GetPermissionsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\ACL\GetPermissions::handle
     */
    public function testSuccessfulGet(): void
    {
        $result = GetPermissions::make()->handle(page: 3);
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::handle
     */
    public function testUnauthorized(): void
    {
        $this->expectException(TypeError::class);
        GetPermissions::make()->handle(page: 'asdfasdf');
    }

}