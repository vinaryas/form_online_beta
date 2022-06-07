<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_ORCL_TNS', ''),
        'host'           => env('DB_ORCL_HOST', ''),
        'port'           => env('DB_ORCL_PORT', '1521'),
        'database'       => env('DB_ORCL_DATABASE', ''),
        'username'       => env('DB_ORCL_USERNAME', ''),
        'password'       => env('DB_ORCL_PASSWORD', ''),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
