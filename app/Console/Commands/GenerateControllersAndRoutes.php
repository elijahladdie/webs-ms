<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateControllersAndRoutes extends Command
{
    protected $signature = 'make:url-controllers';
    protected $description = 'Generate controllers and append resource routes';

    public function handle()
    {
        $this->call('make:controller', [
            'name' => 'PostController',
            '--resource' => true,
        ]);

        $this->call('make:controller', [
            'name' => 'SubscriptionController',
            '--resource' => true,
        ]);

        $this->call('make:controller', [
            'name' => 'WebsiteController',
            '--resource' => true,
        ]);
        $apiRoutesFilePath = base_path('routes/api.php');
        $apiRoutesContent = File::get($apiRoutesFilePath);
        $routesToAdd = "
        use App\Http\Controllers\PostController;
        use App\Http\Controllers\SubscriptionController;
        use App\Http\Controllers\WebsiteController;

        Route::resource('posts', PostController::class);
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('websites', WebsiteController::class);
        ";

        // Check if the routes already exist in api.php
        if (strpos($apiRoutesContent, "Route::resource('posts'") === false &&
            strpos($apiRoutesContent, "Route::resource('subscriptions'") === false &&
            strpos($apiRoutesContent, "Route::resource('websites'") === false) {
                
            // Append the routes to api.php if not found
            File::append($apiRoutesFilePath, $routesToAdd);
            $this->info('Controllers and routes generated and appended successfully!');
        } else {
            $this->info('Routes already exist. No routes were appended.');
        }
    }
}
