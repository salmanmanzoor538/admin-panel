<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_user_roles',
            
            // Role Management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            'manage_permissions',
            
            // Content Management
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'publish_posts',
            
            'view_pages',
            'create_pages',
            'edit_pages',
            'delete_pages',
            'publish_pages',
            
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            'view_tags',
            'create_tags',
            'edit_tags',
            'delete_tags',
            
            'view_comments',
            'moderate_comments',
            'delete_comments',
            
            // Media Management
            'view_media',
            'upload_media',
            'edit_media',
            'delete_media',
            
            // Settings
            'view_settings',
            'edit_settings',
            'manage_site_settings',
            
            // Notifications
            'view_notifications',
            'send_notifications',
            'manage_notifications',
            
            // Analytics
            'view_analytics',
            'export_data',
            
            // System
            'access_admin',
            'manage_system',
            'view_logs',
            'manage_backups',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}