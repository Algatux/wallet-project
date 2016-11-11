<?php

declare(strict_types = 1);

namespace Tests\AppBundle\Service\Wallet;

use Tests\AppBundle\AppTestCase;
use AppBundle\Entity\Wallet;

class WalletPersisterTest extends AppTestCase 
{
    public function test_persist()
    {
        $wallet = new Wallet();
        $wallet->setName('test_wallet');

        $preexistantWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
        ]);

        self::assertEmpty($preexistantWallet);

        $this->getContainer()->get('app.service_wallet.wallet_persister')->persist($wallet);

        $persistedWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
        ]);

        self::assertNotEmpty($persistedWallet);
    }

    public function test_update()
    {
        $wallet = new Wallet();
        $wallet->setName('test_wallet');

        $this->getEm()->persist($wallet);
        $this->getEm()->flush($wallet);

        $preexistantWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
            "description" => null
        ]);

        self::assertNotEmpty($preexistantWallet);

        $wallet->setDescription('ciao ciao ciao');

        $this->getContainer()->get('app.service_wallet.wallet_persister')->update($wallet);

        $updatedWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
            "description" => 'ciao ciao ciao'
        ]);
        $preexistantWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
            "description" => null
        ]);

        self::assertNotEmpty($updatedWallet);
        self::assertEmpty($preexistantWallet);
    }

    public function test_delete()
    {
        $wallet = new Wallet();
        $wallet->setName('test_wallet');

        $this->getEm()->persist($wallet);
        $this->getEm()->flush($wallet);

        $preexistantWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
            "description" => null
        ]);

        self::assertNotEmpty($preexistantWallet);

        $this->getContainer()->get('app.service_wallet.wallet_persister')->delete($wallet);

        $preexistantWallet = $this->getEm()->getRepository(Wallet::class)->findBy([
            "name" => "test_wallet",
            "description" => null
        ]);

        self::assertEmpty($preexistantWallet);
    }
}
