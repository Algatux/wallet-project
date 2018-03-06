<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\MonthlyWallet;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class WalletMigrationCommand extends AbstractCommand
{
    /** @var EntityManagerInterface */
    private $entityManager;

    protected function configure()
    {
        $this->setName('wallet:migration');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->setFormatter(new OutputFormatter(true));
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<INFO>Starting migration</INFO>');

        $walletsIterator = $this->fetchWalletsIterator();

        $question = new Question('<QUESTION>Please enter referenceMonth in ym format:</QUESTION> ');
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        foreach ($walletsIterator as $result) {
            /** @var MonthlyWallet $wallet */
            $wallet = $result[0];

            $output->writeln(sprintf('<INFO>Found wallet "%s"</INFO>', $wallet->getName()));

            $refMonth = $questionHelper->ask($input,$output, $question);

            $wallet->setReferenceMonth($refMonth);

            $this->entityManager->flush();
            $this->entityManager->clear();

            $output->writeln('<INFO>Saved!</INFO>');
        }
    }

    protected function fetchWalletsIterator(): IterableResult
    {
        /** @var WalletRepository $repo */
        $repo = $this->entityManager->getRepository(MonthlyWallet::class);

        $qb = $repo->createQueryBuilder('w');

        $qb->where('w.referenceMonth IS NULL');

        return $qb->getQuery()->iterate();
    }

}