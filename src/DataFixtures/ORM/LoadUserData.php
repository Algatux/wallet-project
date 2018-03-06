<?php declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    const ALGA = 'alga';
    const TEST = 'test';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUserAlga($manager);
        $this->loadUserTest($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadUserAlga(ObjectManager $manager)
    {
        $alga = new User();
        $alga->setUsername(self::ALGA);
        $alga->setPlainPassword(self::ALGA);
        $alga->setNickName('algatux');
        $alga->setFirstName('Alessandro');
        $alga->setLastName('Galli');
        $alga->setEmail('a.galli85@gmail.com');
        $alga->setEnabled(true);

        $manager->persist($alga);

        $this->addReference(self::ALGA, $alga);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadUserTest(ObjectManager $manager)
    {
        $paperino = new User();
        $paperino->setUsername(self::TEST);
        $paperino->setPlainPassword(self::TEST);
        $paperino->setNickName('test');
        $paperino->setFirstName('Paolino');
        $paperino->setLastName('Paperino');
        $paperino->setEmail('pp@duck.com');
        $paperino->setEnabled(true);

        $manager->persist($paperino);

        $this->addReference(self::TEST, $paperino);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
