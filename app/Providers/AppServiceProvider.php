<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in Production
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Global Settings
        if (!\App::runningInConsole()) {
            if (\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key');
                view()->share('global_settings', $settings);
            }

            // Define Gates dynamically based on permissions
            if (\Schema::hasTable('permissions')) {
                try {
                    $permissions = \App\Models\Permission::all();
                    foreach ($permissions as $permission) {
                        \Illuminate\Support\Facades\Gate::define($permission->name, function ($user) use ($permission) {
                            return $user->role->permissions->contains('name', $permission->name);
                        });
                    }
                } catch (\Exception $e) {
                    // Fallback or log if needed (e.g. during migration)
                }
            }
        }
    }
}
