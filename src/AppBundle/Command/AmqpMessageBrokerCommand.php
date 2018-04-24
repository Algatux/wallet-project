<?php declare(strict_types=1);

namespace AppBundle\Command;

use AppBundle\Service\Amqp\AmqpJobFactory;
use AppBundle\Service\Amqp\Model\AmqpWorkerJob;
use AppBundle\Service\Worker\AbstractWorker;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AmqpMessageBrokerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('amqp:message:broker')
            ->addArgument('message', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = base64_decode($input->getArgument('message'));
        if (false === $message) {
            throw new \InvalidArgumentException(sprintf('Cannot decode received encoded message: %s', $message));
        }

        /** @var AmqpWorkerJob $job */
        $job = AmqpJobFactory::buildFromMessage($message);

        if ($input->getOption('verbose')) {
            $output->writeln(
                sprintf(
                    '%s Received from consumer: worker:%s, payload:%s',
                    date('Y/m/d H:i:s', time()),
                    $job->getWorkerFQCN(),
                    json_encode($job->getPayload())
                )
            );
        }

        if (!is_subclass_of($job->getWorkerFQCN(), AbstractWorker::class)) {
            $output->writeln(
                sprintf(
                    '%s Received from consumer -> %s is not a valid worker',
                    date('Y/m/d H:i:s', time()),
                    $job->getWorkerFQCN()
                )
            );

            return 0;
        }

        return $this->getContainer()->get($job->getWorkerFQCN())->run($job);
    }
}
