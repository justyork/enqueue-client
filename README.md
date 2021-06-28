# Enqueue client

### Publish configs

```injectablephp
artisan vendor:publish --provider="Justyork\EnqueueClient\EnqueueClientServiceProvider"
```


## Config
```injectablephp
// ./config/enqueue_client.php
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
            'class' => Enqueue\RdKafka\RdKafkaContext::class
        ]
    ]
];
```
```injectablephp
// ./config/events_map.php
'event_name' => Event::class

```


## Inject in the constructor

#### PHP 8
```injectablephp
public function __construct(protected EnqueueContextClient $context)
{
}
```

#### PHP 7.x
```injectablephp
protected EnqueueContextClient $context;

public function __construct(EnqueueContextClient $context)
{
    $this->context = $context;
}
```

## Usage
### Produce
```injectablephp
// Create topic
$topic = $this->context->createTopic('default');

// Create message
$message = $this->context->createMessage('New message');

// Produce
$this->context->createProducer()->send($topic, $message);
```

### Consume
```injectablephp
run consume:events [topickname]
```
