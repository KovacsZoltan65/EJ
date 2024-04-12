<?php

use Illuminate\Foundation\Application;
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

Route::post('/language', [App\Http\Controllers\LanguageController::class, 'index'])->name('language');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // ------------
    // BOOKS
    // ------------
    Route::post('/getBooks', [App\Http\Controllers\BookController::class, 'getBooks'])->name('getBooks');
    Route::post('/upload-books', [BookController::class, 'upload'])->name('upload-books');
    Route::resource('books', App\Http\Controllers\BookController::class)
    ->names([
          'index' => 'books',
         'create' => 'books_create',
          'store' => 'books_store',
         'update' => 'books_update',
        'destroy' => 'books_destroy',
        'restore' => 'books_restore',
    ]);
    
    // ------------
    // USERS
    // ------------
    Route::post('/getUsers', [App\Http\Controllers\Admin\UserController::class, 'getUsers'])->name('getUsers');
    
    //Route::post('/users_ChangeRole', [App\Http\Controllers\Admin\UserController::class, 'changeRoles'])->name('users_ChangeRole');
    Route::patch(
        '/users_ChangeRole', 
        function(\Illuminate\Http\Request $request) {
            dd($request->id, $request->roles, $request->permissions);
        }
    )->name('users_ChangeRole');
    
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
    ->names([
          'index' => 'users',
         'create' => 'users_create',
          'store' => 'users_store',
           'edit' => 'users_edit',
         'update' => 'users_update',
        'destroy' => 'users_destroy',
        'restore' => 'users_restore',
    ]);
    
    // ------------
    // ROLES
    // ------------
    Route::post('/getRoles', [\App\Http\Controllers\Admin\RoleController::class, 'getRoles'])->name('getRoles');
    Route::resource('/roles', \App\Http\Controllers\Admin\RoleController::class)
    ->names([
          'index' => 'roles',
         'create' => 'roles_create',
          'store' => 'roles_store',
           'edit' => 'roles_edit',
         'update' => 'roles_update',
        'destroy' => 'roles_destroy',
        'restore' => 'roles_restore',
    ]);

    // ------------
    // PERMISSIONS
    // ------------
    Route::post('/getPermissions', [\App\Http\Controllers\Admin\PermissionController::class, 'getPermissions'])->name('getPermissions');
    Route::resource('/permissions', \App\Http\Controllers\Admin\PermissionController::class)
    ->names([
          'index' => 'permissions',
         'create' => 'permissions_create',
          'store' => 'permissions_store',
           'edit' => 'permissions_edit',
         'update' => 'permissions_update',
        'destroy' => 'permissions_destroy',
        'restore' => 'permissions_restore',
    ]);
    
    // ------------
    // SUBDOMAINS
    // ------------
    Route::post('/getSubdomains', [\App\Http\Controllers\SubdomainController::class, 'getSubdomains'])->name('getSubdomains');
    
    Route::resource('/subdomains', \App\Http\Controllers\SubdomainController::class)
    ->names([
          'index' => 'subdomains',
         'create' => 'subdomains_create',
          'store' => 'subdomains_store',
           'edit' => 'subdomains_edit',
         'update' => 'subdomains_update',
        'destroy' => 'subdomains_destroy',
        'restore' => 'subdomains_restore',
    ]);

    // ------------
    // COMPANIES
    // ------------
    Route::get('/companies', function() { dd('Fejlesztés alatt'); })->name('companies.index');

    // ------------
    // KÜLSŐ ADMINOK
    // ------------
    Route::get('/external_admins', function() { dd('Fejlesztés alatt'); })->name('external_admins.index');
});

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => ['auth']],
    function () {
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('role', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('permission', \App\Http\Controllers\Admin\PermissionController::class);
        Route::resource('post', \App\Http\Controllers\Admin\PostController::class);
    });
