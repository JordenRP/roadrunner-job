<?php

namespace App\Runtime;

use Baldinof\RoadRunnerBundle\Runtime\Runner;
use Spiral\RoadRunner\Environment\Mode;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Runtime\RunnerInterface;
use Symfony\Component\Runtime\SymfonyRuntime;

class ConsumerRuntime extends SymfonyRuntime
{
    public function getRunner(?object $application): RunnerInterface
    {
        if (
            $application instanceof HttpKernelInterface
            && false !== getenv('RR_MODE')
            && getenv('RR_MODE') === Mode::MODE_JOBS
        ) {
            return new ConsumerRunner($application);
        }

        if ($application instanceof KernelInterface && false !== getenv('RR_MODE')) {
            return new Runner($application, getenv('RR_MODE'));
        }

        return parent::getRunner($application);
    }
}