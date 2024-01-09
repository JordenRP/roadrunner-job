<?php

namespace App\Runtime;

use Symfony\Component\Runtime\RunnerInterface;
use Spiral\RoadRunner\Jobs\Consumer;

class ConsumerRunner implements RunnerInterface
{

    public function run(): int
    {
        $consumer = new Consumer();

        while ($task = $consumer->waitTask()) {
            try {
                file_put_contents('../../file.txt', $task->getPayload());

                $task->complete();
            } catch (\Throwable $e) {
                $task->fail($e, false);
            }
        }

        return 0;
    }
}