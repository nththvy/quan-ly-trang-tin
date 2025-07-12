<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Các permission từ route
        $permissions = [
            // Dashboard
            'admin.home',

            // Categories
            'admin.categories',
            'admin.categories.create',
            'admin.categories.update',
            'admin.categories.delete',

            // Tags
            'admin.tags',
            'admin.tags.create',
            'admin.tags.update',
            'admin.tags.delete',

            // Statuses
            'admin.statuses',
            'admin.statuses.create',
            'admin.statuses.update',
            'admin.statuses.delete',

            // Roles
            'admin.roles',
            'admin.roles.create',
            'admin.roles.update',
            'admin.roles.delete',

            // Users
            'admin.users',
            'admin.users.create',
            'admin.users.update',
            'admin.users.delete',

            // Articles
            'admin.articles',
            'admin.articles.create',
            'admin.articles.update',
            'admin.articles.delete',
            'admin.articles.uploadImage',
            'admin.check.title',
            'admin.articles.note',
            'admin.articles.send',
            'admin.articles.request_edit',
            'admin.articles.approve_edit',
            'admin.articles.return',
            'admin.articles.unpublish',

            // Comments
            'admin.comments',
            'admin.comments.approve',
            'admin.comments.delete',
            //Subcribers
            'admin.subscribers',
            'admin.subscribers.delete',
        ];

        // Tạo permission nếu chưa có
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Gán tất cả permission cho admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }
    }
}
