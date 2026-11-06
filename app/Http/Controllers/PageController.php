<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        if (!$page->isPublished()) {
            abort(404);
        }

        // Increment views
        $page->incrementViews();

        return view('pages.show', compact('page'));
    }
}