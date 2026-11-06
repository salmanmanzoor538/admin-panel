<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'theme_preference' => 'light',
                'language' => 'en',
                'timezone' => 'UTC',
            ]
        );
        $superAdmin->assignRole('super-admin');

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'theme_preference' => 'dark',
                'language' => 'en',
                'timezone' => 'UTC',
            ]
        );
        $admin->assignRole('admin');

        // Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'I love creating engaging content for our readers.',
                'website' => 'https://example.com',
                'location' => 'New York, USA',
                'birthday' => '1990-05-15',
                'gender' => 'female',
            ]
        );
        $editor->assignRole('editor');

        // Author
        $author = User::firstOrCreate(
            ['email' => 'author@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Tech enthusiast and blogger with 5+ years of experience.',
                'website' => 'https://johndoe.com',
                'location' => 'San Francisco, CA',
                'birthday' => '1985-12-10',
                'gender' => 'male',
            ]
        );
        $author->assignRole('author');

        // Another Author
        $author2 = User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Freelance writer specializing in lifestyle and travel content.',
                'location' => 'London, UK',
                'birthday' => '1992-08-22',
                'gender' => 'female',
            ]
        );
        $author2->assignRole('author');

        // Contributor
        $contributor = User::firstOrCreate(
            ['email' => 'contributor@example.com'],
            [
                'name' => 'Mike Johnson',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Occasional contributor and guest writer.',
                'location' => 'Toronto, Canada',
                'birthday' => '1988-03-18',
                'gender' => 'male',
            ]
        );
        $contributor->assignRole('contributor');

        // Subscriber
        $subscriber = User::firstOrCreate(
            ['email' => 'subscriber@example.com'],
            [
                'name' => 'Sarah Wilson',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'bio' => 'Regular reader and subscriber.',
                'location' => 'Sydney, Australia',
                'birthday' => '1995-11-05',
                'gender' => 'female',
            ]
        );
        $subscriber->assignRole('subscriber');

        // Inactive User
        $inactive = User::firstOrCreate(
            ['email' => 'inactive@example.com'],
            [
                'name' => 'Inactive User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => false,
            ]
        );
        $inactive->assignRole('subscriber');
    }
}