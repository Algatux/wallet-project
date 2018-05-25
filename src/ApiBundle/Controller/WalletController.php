<?php

namespace ApiBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\Wallet;
use AppBundle\Repository\WalletRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletController extends BaseController
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

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

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($wallets,'json', SerializationContext::create()->setGroups(['wallet'])),
            200
        );
    }
}
