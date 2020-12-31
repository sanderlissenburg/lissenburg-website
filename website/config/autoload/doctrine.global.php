<?php

return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => $_ENV['DB_HOST'] ?? '127.0.0.1',
                    'port'     => $_ENV['DB_PORT'] ?? '3306',
                    'user'     => $_ENV['DB_USERNAME'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'dbname'   => $_ENV['DB_DATABASE'],
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
