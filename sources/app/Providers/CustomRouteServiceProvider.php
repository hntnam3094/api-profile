<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CustomRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutes();
    }

    private function loadRoutes () {
        $controllersPath = app_path('Http/Controllers/Office');
        $ignoreArr = [];

        if(File::isDirectory($controllersPath)) {
            $controllers = File::allFiles($controllersPath);

            foreach ($controllers as $controller) {
                $namespace = 'App\\Http\\Controllers\\Office\\';
                $class = $controller->getBasename('.php');
                $routerName = str_replace('Controller', '', $class);

                if(in_array($routerName, $ignoreArr)) {
                    continue;
                }

                if (class_exists($namespace . $class) && !empty($routerName)) {
                    $prefix = strtolower($routerName);

                    Route::prefix('/office/' . $prefix)->group(function () use ($namespace, $class, $prefix) {
                        Route::middleware(['web', 'auth'])->group(function () use ($namespace, $class, $prefix) {
                            Route::get('/index', [$namespace . $class, 'index'])->name($prefix . '.index');
                            Route::get('/create', [$namespace . $class, 'create'])->name($prefix . '.create');
                            Route::post('/store', [$namespace . $class, 'store'])->name($prefix . '.store');
                            Route::get('/edit/{id}', [$namespace . $class, 'edit'])->name($prefix . '.edit');
                            Route::post('/update/{id}', [$namespace . $class, 'update'])->name($prefix . '.update');
                            Route::get('/detail/{id}', [$namespace . $class, 'show'])->name($prefix . '.detail');
                            Route::delete('/delete/{id}', [$namespace . $class, 'destroy'])->name($prefix . '.delete');
                        });
                    });
                }
            }
        }
    }
}
