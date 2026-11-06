<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h1>About Our Company</h1><p>We are a passionate team of developers, designers, and content creators dedicated to building amazing digital experiences.</p><h2>Our Mission</h2><p>To empower individuals and businesses with cutting-edge technology solutions and creative content that makes a difference.</p><h2>Our Values</h2><ul><li><strong>Innovation:</strong> We embrace new technologies and creative approaches</li><li><strong>Quality:</strong> We deliver excellence in everything we do</li><li><strong>Collaboration:</strong> We believe in the power of teamwork</li><li><strong>Integrity:</strong> We operate with honesty and transparency</li></ul><h2>Our Team</h2><p>Our diverse team brings together expertise from various fields, creating a dynamic environment for innovation and growth.</p>',
                'excerpt' => 'Learn more about our company, mission, and the passionate team behind our success.',
                'status' => 'published',
                'template' => 'default',
                'user_id' => $users->first()->id,
                'is_homepage' => false,
                'is_featured' => false,
                'sort_order' => 1,
                'published_at' => now()->subDays(30),
                'meta_title' => 'About Us - Our Company Story and Mission',
                'meta_description' => 'Discover our company story, mission, values, and the passionate team behind our innovative solutions.',
                'meta_keywords' => 'about us, company, team, mission, values',
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h1>Get In Touch</h1><p>We\'d love to hear from you. Whether you have a question about our services, need support, or want to collaborate, we\'re here to help.</p><h2>Contact Information</h2><div class="contact-info"><p><strong>Email:</strong> hello@example.com</p><p><strong>Phone:</strong> +1 (555) 123-4567</p><p><strong>Address:</strong> 123 Business Street, City, State 12345</p></div><h2>Business Hours</h2><p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p><h2>Send Us a Message</h2><p>Use the contact form below to send us a message, and we\'ll get back to you as soon as possible.</p>',
                'excerpt' => 'Contact us for questions, support, or collaboration opportunities. We\'re here to help!',
                'status' => 'published',
                'template' => 'contact',
                'user_id' => $users->first()->id,
                'is_homepage' => false,
                'is_featured' => false,
                'sort_order' => 2,
                'published_at' => now()->subDays(25),
                'meta_title' => 'Contact Us - Get in Touch',
                'meta_description' => 'Contact us for support, questions, or collaboration. Get in touch with our team today.',
                'meta_keywords' => 'contact, support, help, get in touch',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1><p><em>Last updated: ' . now()->format('F d, Y') . '</em></p><h2>Information We Collect</h2><p>We collect information you provide directly to us, such as when you create an account, subscribe to our newsletter, or contact us for support.</p><h2>How We Use Your Information</h2><p>We use the information we collect to:</p><ul><li>Provide, maintain, and improve our services</li><li>Process transactions and send related information</li><li>Send technical notices and support messages</li><li>Respond to your comments and questions</li></ul><h2>Information Sharing</h2><p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p><h2>Data Security</h2><p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p><h2>Your Rights</h2><p>You have the right to access, update, or delete your personal information. You may also opt out of certain communications from us.</p>',
                'excerpt' => 'Our privacy policy explains how we collect, use, and protect your personal information.',
                'status' => 'published',
                'template' => 'default',
                'user_id' => $users->first()->id,
                'is_homepage' => false,
                'is_featured' => false,
                'sort_order' => 3,
                'published_at' => now()->subDays(20),
                'meta_title' => 'Privacy Policy - How We Protect Your Data',
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information.',
                'meta_keywords' => 'privacy policy, data protection, privacy, information security',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h1>Terms of Service</h1><p><em>Last updated: ' . now()->format('F d, Y') . '</em></p><h2>Acceptance of Terms</h2><p>By accessing and using our website and services, you accept and agree to be bound by the terms and provision of this agreement.</p><h2>Use License</h2><p>Permission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only.</p><h2>Disclaimer</h2><p>The materials on our website are provided on an \'as is\' basis. We make no warranties, expressed or implied, and hereby disclaim all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property.</p><h2>Limitations</h2><p>In no event shall our company or its suppliers be liable for any damages arising out of the use or inability to use the materials on our website.</p><h2>Governing Law</h2><p>These terms and conditions are governed by and construed in accordance with the laws and you irrevocably submit to the exclusive jurisdiction of the courts in that state or location.</p>',
                'excerpt' => 'Read our terms of service to understand the rules and regulations for using our website and services.',
                'status' => 'published',
                'template' => 'default',
                'user_id' => $users->first()->id,
                'is_homepage' => false,
                'is_featured' => false,
                'sort_order' => 4,
                'published_at' => now()->subDays(18),
                'meta_title' => 'Terms of Service - Website Usage Terms',
                'meta_description' => 'Read our terms of service to understand the rules and regulations for using our website and services.',
                'meta_keywords' => 'terms of service, terms and conditions, website terms, usage agreement',
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'content' => '<h1>Our Services</h1><p>We offer a comprehensive range of digital services designed to help your business grow and succeed in the digital age.</p><h2>Web Development</h2><p>Custom web applications built with modern technologies like Laravel, React, and Vue.js. We create scalable, secure, and user-friendly solutions.</p><h2>Mobile App Development</h2><p>Native and cross-platform mobile applications for iOS and Android. We use the latest tools and frameworks to deliver exceptional user experiences.</p><h2>Content Management</h2><p>Professional content creation and management services including blog posts, articles, and multimedia content that engages your audience.</p><h2>Digital Marketing</h2><p>Comprehensive digital marketing strategies including SEO, social media marketing, and content marketing to boost your online presence.</p><h2>Consulting</h2><p>Expert consulting services to help you make informed decisions about technology, digital strategy, and business growth.</p>',
                'excerpt' => 'Discover our comprehensive range of digital services including web development, mobile apps, and digital marketing.',
                'status' => 'published',
                'template' => 'services',
                'user_id' => $users->first()->id,
                'is_homepage' => false,
                'is_featured' => true,
                'sort_order' => 5,
                'published_at' => now()->subDays(15),
                'meta_title' => 'Our Services - Digital Solutions for Your Business',
                'meta_description' => 'Explore our digital services including web development, mobile apps, content management, and digital marketing.',
                'meta_keywords' => 'services, web development, mobile apps, digital marketing, consulting',
            ],
            [
                'title' => 'Welcome to Our Blog',
                'slug' => 'welcome-to-our-blog',
                'content' => '<h1>Welcome to Our Blog</h1><p>Thank you for visiting our blog! Here you\'ll find the latest insights, tutorials, and updates from our team.</p><h2>What You\'ll Find Here</h2><p>Our blog covers a wide range of topics including:</p><ul><li>Technology trends and insights</li><li>Web development tutorials</li><li>Business strategies and tips</li><li>Lifestyle and productivity advice</li><li>Travel and remote work experiences</li></ul><h2>Stay Updated</h2><p>Subscribe to our newsletter to get the latest posts delivered directly to your inbox. You can also follow us on social media for real-time updates.</p><h2>Join the Conversation</h2><p>We encourage you to leave comments, share your thoughts, and engage with our community. Your feedback helps us create better content.</p><p>Happy reading!</p>',
                'excerpt' => 'Welcome to our blog! Discover the latest insights, tutorials, and updates from our team.',
                'status' => 'published',
                'template' => 'default',
                'user_id' => $users->first()->id,
                'is_homepage' => true, // This will be the homepage
                'is_featured' => true,
                'sort_order' => 0,
                'published_at' => now()->subDays(50),
                'meta_title' => 'Welcome to Our Blog - Latest Insights and Updates',
                'meta_description' => 'Welcome to our blog featuring the latest technology insights, tutorials, and updates from our expert team.',
                'meta_keywords' => 'blog, welcome, insights, tutorials, updates, technology',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}