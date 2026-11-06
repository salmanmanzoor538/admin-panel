<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest news and insights about technology, software, and digital innovation.',
                'color' => '#3B82F6',
                'icon' => 'computer-desktop',
                'sort_order' => 1,
                'is_active' => true,
                'meta_title' => 'Technology News & Insights',
                'meta_description' => 'Stay updated with the latest technology trends, software reviews, and digital innovation news.',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business strategies, entrepreneurship, and corporate news.',
                'color' => '#10B981',
                'icon' => 'building-office',
                'sort_order' => 2,
                'is_active' => true,
                'meta_title' => 'Business News & Strategies',
                'meta_description' => 'Explore business strategies, entrepreneurship tips, and corporate news.',
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Tips and inspiration for a better lifestyle, health, and wellness.',
                'color' => '#F59E0B',
                'icon' => 'heart',
                'sort_order' => 3,
                'is_active' => true,
                'meta_title' => 'Lifestyle Tips & Inspiration',
                'meta_description' => 'Discover lifestyle tips, health advice, and wellness inspiration.',
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel guides, destination reviews, and adventure stories.',
                'color' => '#EF4444',
                'icon' => 'map',
                'sort_order' => 4,
                'is_active' => true,
                'meta_title' => 'Travel Guides & Destinations',
                'meta_description' => 'Explore amazing destinations with our travel guides and adventure stories.',
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Educational content, tutorials, and learning resources.',
                'color' => '#8B5CF6',
                'icon' => 'academic-cap',
                'sort_order' => 5,
                'is_active' => true,
                'meta_title' => 'Education & Learning Resources',
                'meta_description' => 'Access educational content, tutorials, and learning resources.',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Create subcategories
        $technology = Category::where('slug', 'technology')->first();
        if ($technology) {
            $subcategories = [
                [
                    'name' => 'Programming',
                    'slug' => 'programming',
                    'description' => 'Programming tutorials, code examples, and development tips.',
                    'color' => '#3B82F6',
                    'icon' => 'code-bracket',
                    'parent_id' => $technology->id,
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'name' => 'AI & Machine Learning',
                    'slug' => 'ai-machine-learning',
                    'description' => 'Artificial intelligence, machine learning, and data science.',
                    'color' => '#06B6D4',
                    'icon' => 'cpu-chip',
                    'parent_id' => $technology->id,
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'name' => 'Mobile Development',
                    'slug' => 'mobile-development',
                    'description' => 'iOS, Android, and cross-platform mobile app development.',
                    'color' => '#10B981',
                    'icon' => 'device-phone-mobile',
                    'parent_id' => $technology->id,
                    'sort_order' => 3,
                    'is_active' => true,
                ],
            ];

            foreach ($subcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => $subcategory['slug']],
                    $subcategory
                );
            }
        }
    }
}