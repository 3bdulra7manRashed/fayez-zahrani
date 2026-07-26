<?php

namespace App\Providers;

use App\Models\BookMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        if (request()->is('livewire/*') || request()->hasHeader('X-Livewire')) {
            @ini_set('zlib.output_compression', 'Off');
        }

        View::composer(['components.layouts.admin', 'layouts.admin*'], function ($view) {
            $unreadCount = BookMessage::where('is_read', false)->count();
            $view->with('unreadMessagesCount', $unreadCount);
        });
    }
}
