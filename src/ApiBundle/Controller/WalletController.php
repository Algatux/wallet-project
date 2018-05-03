<?php

namespace ApiBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\Wallet;
use AppBundle\Repository\WalletRepository;
use AppBundle\Service\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletController extends BaseController
{
    /**
     * @Route("/wallets", name="api_wallet_list")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        /** @var WalletRepository $walletRepo */
        $walletRepo = $this->getRepository(Wallet::class);

        $qb = $walletRepo->getVisibleWalletsByUserQb($this->getUser());

        $wallets = $qb->getQuery()->getResult();

        return JsonResponse::create(
            array_map(
                function (Wallet $wallet) {
                    return $this
                        ->get('app.service_serializer.api_serializer')
                        ->serialize($wallet, SerializerInterface::SERIALIZE_ALL);
                },
                $wallets
            ),
            200
        );


    }
}
