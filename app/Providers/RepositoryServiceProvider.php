<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register services.
     */
    public function register(): void {
        //
        $this->app->bind(\App\Interfaces\BookRepositoryInterface::class, \App\Repositories\BookRepository::class);
        $this->app->bind(\App\Interfaces\PermissionRepositoryInterface::class, \App\Repositories\PermissionRepository::class);
        $this->app->bind(\App\Interfaces\PostRepositoryInterface::class, \App\Repositories\PostRepository::class);
        $this->app->bind(\App\Interfaces\RoleRepositoryInterface::class, \App\Repositories\RoleRepository::class);
        $this->app->bind(\App\Interfaces\SubdomainRepositoryInterface::class, \App\Repositories\SubdomainRepository::class);
        $this->app->bind(\App\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        //
    }
}
