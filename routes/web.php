<?php

use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route to show the product with subdomain
Route::domain('{id}.example.test')->group(function () {
    Route::get('{slug}', function () {
        Inertia::render('ProductShow');
    })->name('products.show');
});

//Route to submit a new product and redirect to show it
Route::post('products/create', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'slug' => 'required',
    ]);

    $user_id = $validated['user_id'] = auth()->user()->id;
    $product_slug = $validated['slug'];

    Product::create($validated);

    return redirect()->route('products.show', [$user_id, $product_slug]);
})->name('products.create');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
