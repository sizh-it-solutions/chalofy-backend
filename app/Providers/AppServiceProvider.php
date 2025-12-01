<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use App\Models\{GeneralSetting, Module};
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
        app()->singleton('currentModule', function () {
            return Cache::remember('current_module_default', 6000, function () {
                return Module::where('default_module', '1')->first();
            });
        });

        $settings = Cache::rememberForever('general_settings', function () {
            return GeneralSetting::pluck('meta_value', 'meta_key')->toArray();
        });

        foreach ($settings as $key => $value) {
            Config::set("general.$key", $value);
        }
    }
}
