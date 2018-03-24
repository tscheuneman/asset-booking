<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting;
use Illuminate\Contracts\Cache\Factory;

class AdminSettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot(Factory $cache)
    {

        $globalSettings = Setting::with('adminSetting')->where('global', '=', true)->get();
        $globalSettings = $cache->remember('globalSettings', 60, function() use ($globalSettings)
        {
            // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
            return $globalSettings->pluck('adminSetting.value', 'slug')->all();
        });

        $adminSettings = Setting::with('adminSetting')->where('global', '=', false)->get();
        $adminSettings = $cache->remember('adminSettings', 60, function() use ($adminSettings)
        {
            // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
            return $adminSettings->pluck('adminSetting.value', 'slug')->all();
        });

        config()->set('globalSettings', $globalSettings);
        config()->set('adminSettings', $adminSettings);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
