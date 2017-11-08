<?php declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\MonthlyWallet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadWalletData extends AbstractFixture implements OrderedFixtureInterface
{
    const WALLET_ALGA = 'wallet_alga';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadWalletAlga($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadWalletAlga(ObjectManager $manager)
    {
        $wallet = new MonthlyWallet();
        $wallet->setName(self::WALLET_ALGA);
        $wallet->setDescription('test wallet');
        $wallet->setOwner($this->getReference(LoadUserData::ALGA));

        $manager->persist($wallet);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
