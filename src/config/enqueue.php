<?php

return [
    'transports' => [
        'default' => 'rdkafka',

        'rdkafka' => [
            'dsn' => 'rdkafka://',
            'global' => [
                'group.id' => 'app',
                'metadata.broker.list' => env('KAFKA_HOST'),
                'sasl.mechanisms' => env('KAFKA_MECHANISM'),
                'sasl.username' => env('KAFKA_USERNAME'),
                'sasl.password' => env('KAFKA_PASSWORD'),
                'security.protocol' => env('KAFKA_PROTOCOL'),
            ],
            'factory' => Enqueue\RdKafka\RdKafkaContext::class
        ]
    ]
];
