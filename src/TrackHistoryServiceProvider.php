<?php
namespace Icekristal\LaravelTrackHistory;

use Illuminate\Support\ServiceProvider;

class TrackHistoryServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->registerConfig();
    }
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishMigrations();
            $this->publishConfigs();
        }

    }

    protected function publishMigrations(): void
    {
        if (!class_exists('CreateTrackHistoryTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_track_history_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_track_history_table.php'),
            ], 'migrations');
        }
    }

    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__ . '/../config/track_history.php' => config_path('track_history.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/track_history.php', 'track_history');
    }
}
