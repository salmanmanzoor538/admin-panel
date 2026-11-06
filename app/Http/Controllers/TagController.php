<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display the specified tag.
     */
    public function show(Tag $tag)
    {
        if (!$tag->isActive()) {
            abort(404);
        }

        $posts = Post::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(config('cms.posts.per_page', 10));

        return view('tags.show', compact('tag', 'posts'));
    }
}