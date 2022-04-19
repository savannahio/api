<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Users\Traits;

use App\Auth\Enum\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class HasAppPermissionsTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Traits\HasAppPermissions::isUser
     */
    public function testIsUser(): void
    {
        $user = parent::createUser();
        static::assertTrue($user->isUser($user));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::isUser
     */
    public function testIsNotUser(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->isUser($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewApiDocumentation
     */
    public function testCanViewApiDocumentation(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        static::assertTrue($user->canViewApiDocumentation());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewApiDocumentation
     */
    public function testCannotViewApiDocumentation(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewApiDocumentation());

        $this->expectException(UnauthorizedException::class);
        $user->canViewApiDocumentation(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewHorizon
     */
    public function testCanViewHorizon(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_HORIZON->value]);
        static::assertTrue($user->canViewHorizon());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewHorizon
     */
    public function testCannotViewHorizon(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewHorizon());

        $this->expectException(UnauthorizedException::class);
        $user->canViewHorizon(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewTelescope
     */
    public function testCanViewTelescope(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_TELESCOPE->value]);
        static::assertTrue($user->canViewTelescope());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewTelescope
     */
    public function testCannotViewTelescope(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewTelescope());

        $this->expectException(UnauthorizedException::class);
        $user->canViewTelescope(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canShowUsers
     */
    public function testCanShowUsers(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::SHOW_USERS->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canShowUsers($user_a));
        static::assertTrue($user_a->canShowUsers($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canShowUsers
     */
    public function testCannotShowUsers(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canShowUsers($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canShowUsers($user_b, true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canDeleteUsers
     */
    public function testCanDeleteUsers(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::DELETE_USERS->value]);
        static::assertTrue($user->canDeleteUsers());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canDeleteUsers
     */
    public function testCannotDeleteUsers(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canDeleteUsers());

        $this->expectException(UnauthorizedException::class);
        $user->canDeleteUsers(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUsers
     */
    public function testCanViewUsers(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_USERS->value]);
        static::assertTrue($user->canViewUsers());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUsers
     */
    public function testCannotViewUsers(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewUsers());

        $this->expectException(UnauthorizedException::class);
        $user->canViewUsers(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewPermissions
     */
    public function testCanViewPermissions(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_PERMISSIONS->value]);
        static::assertTrue($user->canViewPermissions());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewPermissions
     */
    public function testCannotViewPermissions(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewPermissions());

        $this->expectException(UnauthorizedException::class);
        $user->canViewPermissions(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewRoles
     */
    public function testCanViewRoles(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_ROLES->value]);
        static::assertTrue($user->canViewRoles());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewRoles
     */
    public function testCannotViewRoles(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canViewRoles());

        $this->expectException(UnauthorizedException::class);
        $user->canViewRoles(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserAddresses
     */
    public function testCanViewUserAddresses(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_ADDRESSES->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canViewUserAddresses($user_a));
        static::assertTrue($user_b->canViewUserAddresses($user_b));
        static::assertTrue($user_a->canViewUserAddresses($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserAddresses
     */
    public function testCannotViewUserAddresses(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canViewUserAddresses($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canViewUserAddresses($user_b, true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserAddresses
     */
    public function testCanUpdateUserAddresses(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_ADDRESSES->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canUpdateUserAddresses($user_a));
        static::assertTrue($user_b->canUpdateUserAddresses($user_b));
        static::assertTrue($user_a->canUpdateUserAddresses($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserAddresses
     */
    public function testCannotUpdateUserAddresses(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canUpdateUserAddresses($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canUpdateUserAddresses($user_b, true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserPermissions
     */
    public function testCanViewUserPermissions(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_PERMISSIONS->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canViewUserPermissions($user_a));
        static::assertTrue($user_b->canViewUserPermissions($user_b));
        static::assertTrue($user_a->canViewUserPermissions($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserPermissions
     */
    public function testCannotViewUserPermissions(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canViewUserPermissions($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canViewUserPermissions($user_b, true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserPermissions
     */
    public function testCanUpdateUserPermissions(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_PERMISSIONS->value]);
        static::assertTrue($user->canUpdateUserPermissions());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserPermissions
     */
    public function testCannotUpdateUserPermissions(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canUpdateUserPermissions());

        $this->expectException(UnauthorizedException::class);
        $user->canUpdateUserPermissions(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserRoles
     */
    public function testCanViewUserRoles(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_ROLES->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canViewUserRoles($user_a));
        static::assertTrue($user_b->canViewUserRoles($user_b));
        static::assertTrue($user_a->canViewUserRoles($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canViewUserRoles
     */
    public function testCannotViewUserRoles(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canViewUserRoles($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canViewUserRoles($user_b, true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserRoles
     */
    public function testCanUpdateUserRoles(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_ROLES->value]);
        static::assertTrue($user->canUpdateUserRoles());
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUserRoles
     */
    public function testCannotUpdateUserRoles(): void
    {
        $user = parent::createUser();
        static::assertFalse($user->canUpdateUserRoles());

        $this->expectException(UnauthorizedException::class);
        $user->canUpdateUserRoles(true);
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUser
     */
    public function testCanUpdateUser(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USERS->value]);
        $user_b = parent::createSecondUser();
        static::assertTrue($user_a->canUpdateUser($user_a));
        static::assertTrue($user_b->canUpdateUser($user_b));
        static::assertTrue($user_a->canUpdateUser($user_b));
    }

    /**
     * @covers \App\Users\Traits\HasAppPermissions::canUpdateUser
     */
    public function testCannotUpdateUser(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createSecondUser();
        static::assertFalse($user_a->canUpdateUser($user_b));

        $this->expectException(UnauthorizedException::class);
        $user_a->canUpdateUser($user_b, true);
    }
}
