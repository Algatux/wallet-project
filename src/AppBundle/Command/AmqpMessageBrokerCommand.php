<?php declare(strict_types=1);

namespace AppBundle\Command;

use AppBundle\Service\Amqp\AmqpJobFactory;
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
        $output->writeln(sprintf('Received message: %s', $message));

        $job = AmqpJobFactory::buildFromMessage($message);

        $this->getContainer()->get($job->getWorkerFQCN())->execute($job);
        exit(0);
    }
}
