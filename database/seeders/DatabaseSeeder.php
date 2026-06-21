<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CitySeeder;
use Database\Seeders\DemoDataSeeder;
use Database\Seeders\ProvinceSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'is_super_admin' => true,
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            DemoDataSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
        ]);
    }
}
