<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\{GeneralSetting, Module};

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        try {
            DB::connection()->getPdo();

            $hasGeneralSettingsTable = Schema::hasTable('general_settings');
            $hasModuleTable = Schema::hasTable('module');
            $currentModule = null;
            View::composer('*', function ($view) use ($hasGeneralSettingsTable, $hasModuleTable) {
                if ($hasGeneralSettingsTable) {
                    $settings = Cache::remember('general_view_settings', 60, function () {
                        return GeneralSetting::whereIn('meta_key', [
                            'general_favicon',
                            'general_logo',
                            'general_name',
                            'general_description',
                        ])->pluck('meta_value', 'meta_key');
                    });

                    $view->with('faviconPath', !empty($settings['general_favicon']) ? "/storage/" . $settings['general_favicon'] : null);
                    $view->with('logoPath', !empty($settings['general_logo']) ? "/storage/" . $settings['general_logo'] : null);
                    $view->with('siteName', $settings['general_name'] ?? null);
                    $view->with('tagLine', $settings['general_description'] ?? null);

                    $general_default_currency = Cache::rememberForever('general_default_currency', function () {
                        return GeneralSetting::where('meta_key', 'general_default_currency')->first();
                    });
                    $view->with('general_default_currency', $general_default_currency);
                }

                if ($hasModuleTable) {
                    $modules = Cache::remember('view_modules_list', 60, function () {
                        return Module::all();
                    });

                    $currentModule = Cache::remember('current_module_default_2', 6000, function () {
                        return Module::where('default_module', '1')->first();
                    });

                    $view->with('modules', $modules);
                    $view->with('currentModule', $currentModule);
                }
            });
        } catch (\PDOException $e) {
            \Log::error('Database connection failed: ' . $e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Query failed: ' . $e->getMessage());
        }
    }
 protected function getCurrentModule(): ?Module
    {
        return Cache::rememberForever('current_module_default_2', function () {
            return Module::where('default_module', '1')->first();
        });
    }
    public function register()
    {
        //
    }
}
