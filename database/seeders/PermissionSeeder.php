<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission_array = [

            //blog
            'access_blogs',
            'access_my_blogs',
            'create_blog',
            'update_blog',
            'view_blog_post',
            'delete_blog',

            //users
            'access_users',

            //comments
            'create_comment',
            'delete_comment',
            'update_comment',
        ];

        $permissions = collect($permission_array)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions->toArray());

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'author'])->givePermissionTo(['access_my_blogs', 'access_blogs', 'create_blog', 'delete_blog', 'update_blog', 'create_comment', 'update_comment', 'view_blog_post']);
        Role::create(['name' => 'user'])->givePermissionTo(['access_blogs', 'create_comment', 'update_comment']);

        User::findOrFail(1)->assignRole('admin');
        User::findOrFail(2)->assignRole('author');
        User::findOrFail(3)->assignRole('user');
    }
}
