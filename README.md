install:
```php
composer require icekristal/laravel-track-history
```
migration:
```php
php artisan vendor:publish --provider="Icekristal\LaravelTrackHistory\TrackHistoryServiceProvider" --tag="migrations"
```

config:
```php
php artisan vendor:publish --provider="Icekristal\LaravelTrackHistory\TrackHistoryServiceProvider" --tag="config"
```
