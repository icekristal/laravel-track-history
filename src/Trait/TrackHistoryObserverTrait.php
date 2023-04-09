<?php

namespace Icekristal\LaravelTrackHistory\Trait;

use Icekristal\LaravelTrackHistory\Jobs\SaveTrackHistoryJob;

trait TrackHistoryObserverTrait
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

    protected function saveDeletedEvent($deletedModel, $deletedRelationshipModel = null, array $other = null): void
    {
        if (method_exists($deletedModel, 'getDeletedAtColumn')) {
            $column = $deletedModel->getDeletedAtColumn();

            dispatch(new SaveTrackHistoryJob(
                $deletedModel,
                ['deleted_at' => $deletedModel->$column],
                ['deleted_at' => null],
                !is_null(auth()->user()) ? auth()->user() : null,
                $deletedRelationshipModel,
                $other
            ));
        }
    }
}
