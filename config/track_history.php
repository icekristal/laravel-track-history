<?php
return [
    'queue' => env("TRACK_HISTORY_QUEUE", 'default'),

    'global_columns_exceptions' => [
        'created_at',
        'updated_at'
    ],

    'models_columns_exceptions' => [
//        YouModel::class => [
//            'type',
//            'other'
//        ] ,
    ],
];
