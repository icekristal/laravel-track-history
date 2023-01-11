<?php

namespace Icekristal\LaravelTrackHistory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property integer $id
 * @property string $table_name
 * @property string $changed_model_type
 * @property integer $changed_model_id
 * @property string $changed_relationship_model_type
 * @property integer $changed_relationship_model_id
 * @property string $change_owner_type
 * @property integer $change_owner_id
 * @property string $changed_column
 * @property string $changed_value_from
 * @property string $changed_value_to
 * @property string $created_at
 * @property string $updated_at
 * @property object $other
 * @property object $translates
 */
class TrackHistory extends Model
{
    /**
     *
     * Name Table
     * @var string
     */
    protected $table = 'track_history';


    protected $fillable = [
        'table_name', 'changed_model_type', 'changed_model_id', 'changed_relationship_model_type', 'changed_relationship_model_id',
        'change_owner_type', 'change_owner_id', 'changed_column', 'changed_value_from', 'changed_value_to', 'other', 'translates'
    ];

    /**
     *
     * Mutation
     *
     * @var array
     */
    protected $casts = [
        'other' => 'object',
        'translates' => 'object',
    ];

    /**
     *
     * @return MorphTo
     */
    public function changedModel(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     *
     * @return MorphTo
     */
    public function changedRelationshipModel(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     *
     * @return MorphTo
     */
    public function changeOwner(): MorphTo
    {
        return $this->morphTo();
    }
}
