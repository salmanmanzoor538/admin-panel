<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $posts = [
            [
                'title' => 'Getting Started with Laravel 11: A Complete Guide',
                'slug' => 'getting-started-with-laravel-11',
                'excerpt' => 'Learn the fundamentals of Laravel 11 and build your first application with this comprehensive guide.',
                'content' => '<p>Laravel 11 brings exciting new features and improvements to the popular PHP framework. In this comprehensive guide, we\'ll explore everything you need to know to get started with Laravel 11.</p><h2>What\'s New in Laravel 11</h2><p>Laravel 11 introduces several key improvements including enhanced performance, new Artisan commands, and improved developer experience.</p><h2>Installation</h2><p>To install Laravel 11, you can use Composer:</p><pre><code>composer create-project laravel/laravel my-app</code></pre><p>This will create a new Laravel application with all the latest features.</p><h2>Key Features</h2><ul><li>Improved routing system</li><li>Enhanced authentication</li><li>Better database management</li><li>Advanced caching mechanisms</li></ul><p>With these improvements, Laravel 11 continues to be the go-to framework for modern PHP development.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'user_id' => $users->first()->id,
                'category_id' => $categories->where('slug', 'technology')->first()?->id,
                'is_featured' => true,
                'allow_comments' => true,
                'meta_title' => 'Laravel 11 Complete Guide - Getting Started Tutorial',
                'meta_description' => 'Learn Laravel 11 from scratch with this comprehensive guide. Includes installation, key features, and best practices.',
                'meta_keywords' => 'Laravel, PHP, Framework, Tutorial, Guide, Web Development',
            ],
            [
                'title' => 'Building Modern Web Applications with React and Laravel',
                'slug' => 'building-modern-web-applications-react-laravel',
                'excerpt' => 'Discover how to create powerful full-stack applications by combining React frontend with Laravel backend.',
                'content' => '<p>In today\'s web development landscape, combining React with Laravel provides a powerful stack for building modern applications.</p><h2>Why React + Laravel?</h2><p>React offers excellent component-based architecture while Laravel provides a robust backend framework. Together, they create a perfect combination for scalable web applications.</p><h2>Setting Up the Environment</h2><p>First, create a new Laravel project:</p><pre><code>laravel new my-app</code></pre><p>Then set up React using Laravel Mix or Vite:</p><pre><code>npm install react react-dom</code></pre><h2>API Development</h2><p>Laravel\'s API resources make it easy to create RESTful APIs that work seamlessly with React frontends.</p><h2>State Management</h2><p>Consider using Redux or Context API for managing state in your React application.</p><p>This combination provides excellent developer experience and performance.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'user_id' => $users->skip(1)->first()->id,
                'category_id' => $categories->where('slug', 'technology')->first()?->id,
                'is_featured' => false,
                'allow_comments' => true,
                'meta_title' => 'React + Laravel: Building Modern Web Applications',
                'meta_description' => 'Learn how to build full-stack applications with React frontend and Laravel backend. Complete tutorial with examples.',
                'meta_keywords' => 'React, Laravel, Full-stack, JavaScript, PHP, API',
            ],
            [
                'title' => 'The Future of Remote Work: Trends and Predictions',
                'slug' => 'future-of-remote-work-trends-predictions',
                'excerpt' => 'Explore the evolving landscape of remote work and what the future holds for distributed teams.',
                'content' => '<p>Remote work has transformed the way we think about employment and collaboration. As we look ahead, several trends are shaping the future of distributed work.</p><h2>Key Trends</h2><p>The shift to remote work has accelerated digital transformation and changed employee expectations.</p><h2>Technology Solutions</h2><p>Companies are investing heavily in collaboration tools, project management software, and communication platforms.</p><h2>Work-Life Balance</h2><p>Remote work offers flexibility but also presents challenges in maintaining boundaries between work and personal life.</p><h2>Future Predictions</h2><ul><li>Hybrid work models will become standard</li><li>Increased focus on employee well-being</li><li>Advanced collaboration tools</li><li>Global talent access</li></ul><p>The future of work is distributed, and organizations must adapt to succeed in this new landscape.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'user_id' => $users->skip(2)->first()->id,
                'category_id' => $categories->where('slug', 'business')->first()?->id,
                'is_featured' => true,
                'allow_comments' => true,
                'meta_title' => 'Future of Remote Work: Trends and Predictions 2024',
                'meta_description' => 'Discover the latest trends and predictions for remote work. Learn about the future of distributed teams and workplace evolution.',
                'meta_keywords' => 'Remote Work, Future of Work, Distributed Teams, Workplace Trends',
            ],
            [
                'title' => 'Sustainable Living: Simple Changes for a Better Planet',
                'slug' => 'sustainable-living-simple-changes-better-planet',
                'excerpt' => 'Discover practical ways to live more sustainably and reduce your environmental impact.',
                'content' => '<p>Sustainable living doesn\'t have to be complicated. Small changes in our daily habits can make a significant impact on the environment.</p><h2>Energy Conservation</h2><p>Simple steps like using LED bulbs, unplugging devices, and optimizing heating and cooling can reduce energy consumption.</p><h2>Waste Reduction</h2><p>Embrace the three Rs: Reduce, Reuse, and Recycle. Consider composting and avoiding single-use plastics.</p><h2>Transportation</h2><p>Walking, cycling, or using public transportation when possible reduces carbon emissions significantly.</p><h2>Sustainable Shopping</h2><ul><li>Choose local and seasonal products</li><li>Support eco-friendly brands</li><li>Buy quality items that last</li><li>Consider second-hand options</li></ul><p>Every small action contributes to a more sustainable future for our planet.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'user_id' => $users->skip(3)->first()->id,
                'category_id' => $categories->where('slug', 'lifestyle')->first()?->id,
                'is_featured' => false,
                'allow_comments' => true,
                'meta_title' => 'Sustainable Living Guide: Simple Changes for Environment',
                'meta_description' => 'Learn practical sustainable living tips to reduce your environmental impact. Simple changes for a better planet.',
                'meta_keywords' => 'Sustainable Living, Environment, Eco-friendly, Green Living, Conservation',
            ],
            [
                'title' => 'Top 10 Destinations for Digital Nomads in 2024',
                'slug' => 'top-10-destinations-digital-nomads-2024',
                'excerpt' => 'Explore the best destinations for digital nomads, featuring great internet, affordable living, and vibrant communities.',
                'content' => '<p>Digital nomadism continues to grow, and certain destinations stand out for their nomad-friendly infrastructure and lifestyle.</p><h2>Lisbon, Portugal</h2><p>With its vibrant culture, excellent internet, and growing nomad community, Lisbon tops many lists.</p><h2>Bangkok, Thailand</h2><p>Affordable living costs, great food, and reliable internet make Bangkok a popular choice.</p><h2>Mexico City, Mexico</h2><p>Rich culture, modern amenities, and a large expat community attract many digital nomads.</p><h2>Other Top Destinations</h2><ul><li>Bali, Indonesia</li><li>Berlin, Germany</li><li>Chiang Mai, Thailand</li><li>Medellín, Colombia</li><li>Prague, Czech Republic</li><li>Tallinn, Estonia</li><li>Valencia, Spain</li></ul><p>Each destination offers unique advantages for remote workers seeking adventure and productivity.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'user_id' => $users->skip(4)->first()->id,
                'category_id' => $categories->where('slug', 'travel')->first()?->id,
                'is_featured' => true,
                'allow_comments' => true,
                'meta_title' => 'Best Digital Nomad Destinations 2024 - Remote Work Locations',
                'meta_description' => 'Discover the top destinations for digital nomads in 2024. Find the best places to work remotely with great infrastructure.',
                'meta_keywords' => 'Digital Nomad, Remote Work, Travel, Nomad Destinations, Work from Anywhere',
            ],
            [
                'title' => 'Learning PHP: From Beginner to Advanced',
                'slug' => 'learning-php-beginner-to-advanced',
                'excerpt' => 'A comprehensive roadmap for learning PHP, covering fundamentals to advanced concepts.',
                'content' => '<p>PHP remains one of the most popular server-side programming languages, powering millions of websites worldwide.</p><h2>Getting Started</h2><p>Begin with basic syntax, variables, and data types. PHP\'s gentle learning curve makes it accessible for beginners.</p><h2>Core Concepts</h2><p>Master functions, arrays, loops, and conditional statements. These form the foundation of PHP programming.</p><h2>Object-Oriented Programming</h2><p>Learn classes, objects, inheritance, and polymorphism. OOP is essential for building maintainable applications.</p><h2>Advanced Topics</h2><ul><li>Database integration with PDO</li><li>Security best practices</li><li>Performance optimization</li><li>Framework usage (Laravel, Symfony)</li><li>API development</li></ul><p>With dedication and practice, you can become proficient in PHP and build powerful web applications.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'user_id' => $users->first()->id,
                'category_id' => $categories->where('slug', 'education')->first()?->id,
                'is_featured' => false,
                'allow_comments' => true,
                'meta_title' => 'PHP Learning Guide: Beginner to Advanced Tutorial',
                'meta_description' => 'Complete PHP learning roadmap from basics to advanced concepts. Master server-side programming with practical examples.',
                'meta_keywords' => 'PHP, Programming, Tutorial, Web Development, Server-side, Learning',
            ],
            [
                'title' => 'The Art of Minimalist Web Design',
                'slug' => 'art-of-minimalist-web-design',
                'excerpt' => 'Explore the principles of minimalist web design and how to create clean, effective user interfaces.',
                'content' => '<p>Minimalist web design focuses on simplicity and functionality, creating user experiences that are both beautiful and effective.</p><h2>Core Principles</h2><p>Less is more. Minimalist design emphasizes white space, typography, and essential elements only.</p><h2>Color Palette</h2><p>Stick to a limited color palette, often using neutral colors with one or two accent colors.</p><h2>Typography</h2><p>Choose clean, readable fonts and establish a clear hierarchy through size and weight.</p><h2>Layout and Spacing</h2><ul><li>Use generous white space</li><li>Create clear visual hierarchy</li><li>Focus on content</li><li>Remove unnecessary elements</li></ul><p>Minimalist design creates timeless, user-friendly interfaces that stand the test of time.</p>',
                'status' => 'draft',
                'user_id' => $users->skip(1)->first()->id,
                'category_id' => $categories->where('slug', 'technology')->first()?->id,
                'is_featured' => false,
                'allow_comments' => true,
                'meta_title' => 'Minimalist Web Design: Principles and Best Practices',
                'meta_description' => 'Learn minimalist web design principles to create clean, effective user interfaces. Design tips and best practices.',
                'meta_keywords' => 'Web Design, Minimalism, UI/UX, Design Principles, User Interface',
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::firstOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );

            // Attach random tags
            if ($tags->isNotEmpty()) {
                $randomTags = $tags->random(rand(2, 5));
                $post->tags()->sync($randomTags->pluck('id'));
            }
        }

        // Update tag usage counts
        foreach ($tags as $tag) {
            $tag->updateUsageCount();
        }
    }
}