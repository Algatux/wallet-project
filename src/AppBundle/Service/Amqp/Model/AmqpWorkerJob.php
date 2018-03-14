<?php declare(strict_types=1);

namespace AppBundle\Service\Amqp\Model;

class AmqpWorkerJob extends AmqpJob
{
    /** @var string */
    private $workerFQCN;

    public function __construct(string $fqcn, array $payload)
    {
        parent::__construct($payload);
        $this->workerFQCN = $fqcn;
    }

    public function getWorkerFQCN(): string
    {
        return $this->workerFQCN;
    }

    public function publish()
    {
        return array_merge(parent::publish(), ["workerFQCN" => $this->workerFQCN]);
    }
}
