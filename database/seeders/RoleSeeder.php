<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        $admin->syncPermissions(Permission::all());

        $editor->syncPermissions(
            Permission::whereIn('name', [
                'post.view',
                'post.create',
                'post.edit',
                'comment.view',
                'comment.create',
                'comment.edit',
            ])->get()
        );

        $viewer->syncPermissions(
            Permission::whereIn('name', [
                'post.view',
                'comment.view',
            ])->get()
        );
    }
}
