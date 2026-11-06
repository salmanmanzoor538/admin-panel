<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Laravel PHP framework',
                'color' => '#FF2D20',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'PHP',
                'slug' => 'php',
                'description' => 'PHP programming language',
                'color' => '#777BB4',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'JavaScript programming language',
                'color' => '#F7DF1E',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'React',
                'slug' => 'react',
                'description' => 'React JavaScript library',
                'color' => '#61DAFB',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Vue.js',
                'slug' => 'vue-js',
                'description' => 'Vue.js JavaScript framework',
                'color' => '#4FC08D',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Node.js',
                'slug' => 'node-js',
                'description' => 'Node.js JavaScript runtime',
                'color' => '#339933',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Python',
                'slug' => 'python',
                'description' => 'Python programming language',
                'color' => '#3776AB',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Docker',
                'slug' => 'docker',
                'description' => 'Docker containerization platform',
                'color' => '#2496ED',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'AWS',
                'slug' => 'aws',
                'description' => 'Amazon Web Services',
                'color' => '#FF9900',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'MySQL',
                'slug' => 'mysql',
                'description' => 'MySQL database management system',
                'color' => '#4479A1',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Step-by-step tutorials and guides',
                'color' => '#10B981',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Tips',
                'slug' => 'tips',
                'description' => 'Useful tips and tricks',
                'color' => '#F59E0B',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'News',
                'slug' => 'news',
                'description' => 'Latest news and updates',
                'color' => '#EF4444',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Review',
                'slug' => 'review',
                'description' => 'Product and service reviews',
                'color' => '#8B5CF6',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Beginner',
                'slug' => 'beginner',
                'description' => 'Content for beginners',
                'color' => '#06B6D4',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Advanced',
                'slug' => 'advanced',
                'description' => 'Advanced level content',
                'color' => '#DC2626',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Web development topics',
                'color' => '#7C3AED',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Mobile app development',
                'color' => '#059669',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'DevOps practices and tools',
                'color' => '#0891B2',
                'is_active' => true,
                'usage_count' => 0,
            ],
            [
                'name' => 'Security',
                'slug' => 'security',
                'description' => 'Cybersecurity and data protection',
                'color' => '#DC2626',
                'is_active' => true,
                'usage_count' => 0,
            ],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => $tag['slug']],
                $tag
            );
        }
    }
}