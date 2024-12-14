<?php

return [
    /**
     * Table names for packages
     */
    'table_names' => [
        /**
         * Table names for provinces
         *
         * @var string
         */
        'provinces' => 'id_provinces',

        /**
         * Table names for regencies
         *
         * @var string
         */
        'regencies' => 'id_regencies',

        /**
         * Table names for districts
         *
         * @var string
         */
        'districts' => 'id_districts',

        /**
         * Table names for villages
         *
         * @var string
         */
        'villages' => 'id_villages',
    ],

    'cache' => [
        /**
         * By default the expiration time is set to 7 days to speed up performance
         * When the data is updated, the cache will be cleared automatically
         */
        'expiration_time' => \DateInterval::createFromDateString('7 days'),

        /**
         * The prefix for the cache key
         */
        'prefix' => 'territory:',

        /*
         * The laravel cache store to use for caching
         * Using "default" here means to use the `default` set in cache.php.
         */
        'store' => 'default',
    ],

    /**
     * The database connection to use
     */
    'connection' => env('ID_TERRITORY_DB_CONNECTION', null),
];
