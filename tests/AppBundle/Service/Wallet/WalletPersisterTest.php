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
}
