<?php

declare(strict_types = 1);

namespace Tests\AppBundle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppTestCase extends WebTestCase
{
    /** @var  Client */
    private $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createClient();
        $this->getEm()->beginTransaction();
    }

    public function tearDown()
    {
        $this->getEm()->rollback();

        parent::tearDown();
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->client->getContainer();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
    }
}
