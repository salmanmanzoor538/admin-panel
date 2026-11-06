<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin Role
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // Admin Role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'access_admin',
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_posts', 'create_posts', 'edit_posts', 'delete_posts', 'publish_posts',
            'view_pages', 'create_pages', 'edit_pages', 'delete_pages', 'publish_pages',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_tags', 'create_tags', 'edit_tags', 'delete_tags',
            'view_comments', 'moderate_comments', 'delete_comments',
            'view_media', 'upload_media', 'edit_media', 'delete_media',
            'view_settings', 'edit_settings',
            'view_notifications', 'send_notifications',
            'view_analytics', 'export_data',
        ]);

        // Editor Role
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->givePermissionTo([
            'view_posts', 'create_posts', 'edit_posts', 'publish_posts',
            'view_pages', 'create_pages', 'edit_pages', 'publish_pages',
            'view_categories', 'create_categories', 'edit_categories',
            'view_tags', 'create_tags', 'edit_tags',
            'view_comments', 'moderate_comments',
            'view_media', 'upload_media', 'edit_media',
            'view_notifications',
            'view_analytics',
        ]);

        // Author Role
        $author = Role::firstOrCreate(['name' => 'author']);
        $author->givePermissionTo([
            'view_posts', 'create_posts', 'edit_posts',
            'view_pages', 'create_pages', 'edit_pages',
            'view_categories', 'view_tags',
            'view_media', 'upload_media',
            'view_notifications',
        ]);

        // Contributor Role
        $contributor = Role::firstOrCreate(['name' => 'contributor']);
        $contributor->givePermissionTo([
            'view_posts', 'create_posts', 'edit_posts',
            'view_media', 'upload_media',
            'view_notifications',
        ]);

        // Subscriber Role
        $subscriber = Role::firstOrCreate(['name' => 'subscriber']);
        $subscriber->givePermissionTo([
            'view_notifications',
        ]);
    }
}