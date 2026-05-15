<?php

use Orm\Model;

class Model_Queue extends Model
{
    protected static $_table_name = 'queues';

    protected static $_properties = [

        'id',

        'type',

        'payload',

        'status',

        'attempts',

        'error_text',

        'available_at',

        'processed_at',

        'created_at',

        'updated_at',
    ];

    protected static $_observers = [

        'Orm\\Observer_CreatedAt' => [
            'events' => ['before_insert'],
            'mysql_timestamp' => false,
        ],

        'Orm\\Observer_UpdatedAt' => [
            'events' => ['before_save'],
            'mysql_timestamp' => false,
        ],
    ];
}