<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        // Get homepage from settings or default page
        $homepage = Page::where('is_homepage', true)->published()->first();
        
        if ($homepage) {
            return view('pages.show', compact('homepage'));
        }

        // Fallback to blog index
        $featuredPosts = Post::featured()->published()->limit(6)->get();
        $recentPosts = Post::published()->latest('published_at')->limit(8)->get();
        $categories = Category::active()->with('publishedPosts')->get();
        
        return view('home', compact('featuredPosts', 'recentPosts', 'categories'));
    }
}