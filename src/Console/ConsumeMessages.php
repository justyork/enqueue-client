<?php

namespace Justyork\EnqueueClient\Console;

use Illuminate\Console\Command;
use Justyork\EnqueueClient\EnqueueContextClient;

class ConsumeMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:events {topic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event consumer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected EnqueueContextClient $context)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $topic = $this->context->createTopic($this->argument('topic'));
        $consumer = $this->context->createConsumer($topic);

        $eventsMap = config('events_map');

        echo "-- Start listening --";
        while (true) {
            $message = $consumer->receive();
            echo "-- Receive new message --";
            $messageBody = $message->getBody();

            if (is_string($messageBody)) {
                $messageBody = json_decode($messageBody, true);
            }

            if (($messageBody['event'] ?? false) && ($eventsMap[$messageBody['event']] ?? false)) {
                echo "-- Dispatch event ${$messageBody['event']} --";
                $eventClassName = $eventsMap[$messageBody['event']];
                $eventClassName::dispach($messageBody);
            }

            $consumer->acknowledge($message);
        }
    }
}
