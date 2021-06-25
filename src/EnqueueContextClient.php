<?php


namespace Justyork\EnqueueClient;


use Interop\Queue\Consumer;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Queue;
use Interop\Queue\SubscriptionConsumer;
use Interop\Queue\Topic;

class EnqueueContextClient implements Context
{
    protected Context $context;

    /**
     * EnqueueClient constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }


    public function createMessage(string $body = '', array $properties = [], array $headers = []): Message
    {
        return $this->context->createMessage($body, $properties, $headers);
    }

    public function createTopic(string $topicName): Topic
    {
        return  $this->context->createTopic($topicName);
    }

    public function createQueue(string $queueName): Queue
    {
        return $this->context->createQueue($queueName);
    }

    public function createTemporaryQueue(): Queue
    {
        return $this->context->createTemporaryQueue();
    }

    public function createProducer(): Producer
    {
        return $this->context->createProducer();
    }

    public function createConsumer(Destination $destination): Consumer
    {
        return $this->context->createConsumer($destination);
    }

    public function createSubscriptionConsumer(): SubscriptionConsumer
    {
        return $this->context->createSubscriptionConsumer();
    }

    public function purgeQueue(Queue $queue): void
    {
        $this->context->purgeQueue($queue);
    }

    public function close(): void
    {
        $this->context->close();
    }
}
