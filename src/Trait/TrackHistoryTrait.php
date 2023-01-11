<?php

namespace Icekristal\LaravelTrackHistory\Trait;

use Icekristal\LaravelTrackHistory\Models\TrackHistory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait TrackHistoryTrait
{
    public function trackHistory(): MorphMany
    {
        return $this->morphMany(TrackHistory::class, 'changed_model');
    }

    public function trackHighHistory(): MorphMany
    {
        return $this->morphMany(TrackHistory::class, 'changed_h_model');
    }
}
