# Enqueue client

## Config

```injectablephp
// ./config/enqueue.php
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


##Inject in the constructor

####PHP 8
```injectablephp
    
    public function __construct(protected EnqueueContextClient $context)
    {
    }
```

####PHP 7.x
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
$topic = $this->context->createTopic('default');
$consumer = $this->context->createConsumer($topic);

while (true) {
    $message = $consumer->receive();
    // do something
    $consumer->acknowledge($message);
}
```
