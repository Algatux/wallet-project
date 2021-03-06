<?php declare(strict_types=1);

namespace AppBundle\Service\Worker;

use AppBundle\Service\Amqp\Model\AmqpWorkerJob;

abstract class AbstractWorker
{
    abstract public function execute(AmqpWorkerJob $job);

    public function run(AmqpWorkerJob $job): int
    {
        try {

            return $this->execute($job);

        } catch (\Exception $e) {

            return 4;
        }
    }
}