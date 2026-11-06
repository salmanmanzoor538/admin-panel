<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blog routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category');
    Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tag');
    Route::get('/{post:slug}', [PostController::class, 'show'])->name('show');
});

// Pages
Route::get('/{page:slug}', [PageController::class, 'show'])->name('page.show');

// Admin panel navigation state routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::post('/menu-state', function (\Illuminate\Http\Request $request) {
        session(['filament.menu.state' => $request->input('state')]);
        return response()->json(['success' => true]);
    })->name('admin.menu.state');
    
    Route::post('/navigation-type', function (\Illuminate\Http\Request $request) {
        session(['filament.navigation.type' => $request->input('type')]);
        return response()->json(['success' => true]);
    })->name('admin.navigation.type');
    
    // File upload routes
    Route::post('/upload', function (\Illuminate\Http\Request $request) {
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            return response()->json(['success' => true, 'path' => $path]);
        }
        return response()->json(['success' => false], 400);
    })->name('admin.upload');
    
    // Calendar routes
    Route::get('/calendar/events', function () {
        // Return calendar events
        return response()->json([]);
    })->name('admin.calendar.events');
    
    Route::put('/calendar/events/{id}', function ($id, \Illuminate\Http\Request $request) {
        // Update calendar event
        return response()->json(['success' => true]);
    })->name('admin.calendar.events.update');
});

// Fallback for 404
Route::fallback(function () {
    return view('errors.404');
});