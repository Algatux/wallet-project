<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Wallet;
use AppBundle\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api/wallet")
 */
class WalletController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/list", name="api_wallet_list")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function listAction()
    {
        /** @var WalletRepository $walletRepo */
        $walletRepo = $this->entityManager->getRepository(Wallet::class);

        $qb = $walletRepo->getVisibleWalletsByUserQb($this->tokenStorage->getToken()->getUser());

        return new JsonResponse($qb->getQuery()->getResult());
    }
}
