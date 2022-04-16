<?php

declare(strict_types=1);

namespace Database\Seeders;

use Cache;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->runPreSteps();
        $this->call(ACLSeeder::class);
        $this->call(UserSeeder::class);
    }

    private function runPreSteps(): void
    {
        //  https://spatie.be/docs/laravel-permission/v5/advanced-usage/seeding#content-flush-cache-before-seeding
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Cache::flush();
    }
}
