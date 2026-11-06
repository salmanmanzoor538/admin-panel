<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        if (!$category->isActive()) {
            abort(404);
        }

        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['author', 'tags'])
            ->latest('published_at')
            ->paginate(config('cms.posts.per_page', 10));

        return view('categories.show', compact('category', 'posts'));
    }
}