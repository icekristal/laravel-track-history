<?php

namespace Icekristal\LaravelTrackHistory\Jobs;

use Icekristal\LaravelTrackHistory\Models\TrackHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveTrackHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $changedModel,
        public $dirtyAttribute,
        public $changeOwner = null,
        public $changedRelationshipModel = null,
        public $otherInfo = null)
    {
        $this->onQueue(config('track_history.queue', 'default'));
    }

    /**
     *
     *
     * @return void
     */
    public function handle(): void
    {
        $additionalExceptions = [];
        if (!is_null(config('track_history.models_columns_exceptions.' . $this->changedModel::class)) && is_array(config('track_history.models_columns_exceptions.' . $this->changedModel::class))) {
            $additionalExceptions = config('track_history.models_columns_exceptions.' . $this->changedModel::class);
        }
        $columnsExceptions = config('track_history.global_columns_exceptions') + $additionalExceptions;
        if (!is_array($columnsExceptions)) {
            Log::error("columnsExceptions in not array");
            return;
        }

        collect($this->dirtyAttribute)->filter(function ($value, $key) use ($columnsExceptions) {
            return !in_array($key, $columnsExceptions);
        })->mapWithKeys(function ($value, $key) {
            TrackHistory::query()->create([
                'table_name' => $this->changedModel?->getTable() ?? null,
                'changed_model_type' => get_class($this->changedModel),
                'changed_model_id' => $this->changedModel->id,
                'changed_h_model_type' => !is_null($this->changedRelationshipModel) ? get_class($this->changedRelationshipModel) : null,
                'changed_h_model_id' => !is_null($this->changedRelationshipModel) ? $this->changedRelationshipModel->id : null,
                'change_owner_type' => !is_null($this->changeOwner) ? get_class($this->changeOwner) : null,
                'change_owner_id' => !is_null($this->changeOwner) ? $this->changeOwner->id : null,
                'changed_column' => $key,
                'changed_value_from' => $this->changedModel?->getOriginal($key) ?? null,
                'changed_value_to' => $value ?? null,
                'other' => $this->otherInfo,
                'translates' => null,
            ]);
        });
    }
}
