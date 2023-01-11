<?php

namespace Icekristal\LaravelTrackHistory\Trait;

use Icekristal\LaravelTrackHistory\Jobs\SaveTrackHistoryJob;

trait TrackHistoryTrait
{
    protected function saveHistory($changeModel, $changedRelationshipModel = null, array $other = null): void
    {
        dispatch(new SaveTrackHistoryJob(
            $changeModel,
            $changeModel->getDirty(),
            $changeModel->getOriginal(),
            !is_null(auth()->user()) ? auth()->user() : null,
            $changedRelationshipModel,
            $other
        ));
    }
}
