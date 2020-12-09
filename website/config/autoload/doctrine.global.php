<?php

return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => 'mysql',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'secret',
                    'dbname'   => 'lissenburg_website',
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name' => 'migrations',
                ],
                'migrations_paths' => [
                    'App\Migrations' => __DIR__ . '/../../src/App/Migration'
                ]
            ],
        ]
    ],
];
