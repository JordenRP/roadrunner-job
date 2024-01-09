<?php

namespace App\Controller;

use Spiral\Goridge\RPC\RPC;
use Spiral\RoadRunner\Jobs\Jobs;
use Spiral\RoadRunner\Jobs\KafkaOptions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route(path: '/test/{param}', methods: ['GET'])]
    public function __invoke(string $param)
    {
        $jobs = new Jobs(
            RPC::create('tcp://127.0.0.1:6001')
        );

        $queue = $jobs->connect('test',  new KafkaOptions(
            topic: 'test'
        ));

        $task = $queue->create(
            'test',
            json_encode(['foo' => $param]),
        )->withAutoAck(false);
        $queue->dispatch($task);

        return $this->json([]);
    }
}