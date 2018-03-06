<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Model\Chartjs\WalletTotalTrendDataModel;
use App\Repository\WalletRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/wallet/old")
 */
class WalletController extends BaseController
{
    /**
     * @Route("/list", name="app_wallet_list")
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function listAction(Request $request)
    {
        /** @var WalletRepository $walletRepo */
        $walletRepo = $this->getRepository(Wallet::class);

        $qb = $walletRepo->getVisibleWalletsByUserQb($this->getUser());

        $paginator = $this->get('facile.paginator');
        $paginator->parseRequest($request);
        $paginator->setNumberOfElementsPerPage(10);

        $walletRepo->getVisibleWalletsByUser($this->getUser());

        $wallets = $paginator->paginate($qb);
        $trendModel = WalletTotalTrendDataModel::buildWithWalletList($wallets);

        return [
            "paginationInfo" => $paginator->getPaginationInfo($qb),
            "wallets" => $wallets,
            "trendModel" => $trendModel
        ];
    }

    /**
     * @Route("/{wallet}/detail", name="app_wallet_detail")
     * @Template()
     *
     * @param Wallet $wallet
     *
     * @return array
     */
    public function detailAction(Wallet $wallet)
    {
        $this->denyAccessUnlessGranted('VIEW', $wallet);

        return [
            "wallet" => $wallet,
            "totalTransactioned" => $this->getEm()
                ->getRepository(Wallet::class)
                ->getTotalAmountTrasferedByWallet($wallet),
            "singleTransactionerAmounts" => $this->getEm()
                ->getRepository(Wallet::class)
                ->getSingleTransactionerAmountByWallet($wallet),
        ];
    }

    /**
     * @Route("/create", name="app_wallet_create")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(
            WalletType::class,
            null,
            ["owner" => $this->getUser()]
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            /** @var Wallet $wallet */
            $wallet = $form->getData();
            $wallet->setOwner($this->getUser());

            $this->getEm()->beginTransaction();
            try{
                $this->get('app.service_wallet.wallet_persister')->persist($wallet);
                $this->flashNotification(sprintf('Wallet %s successfully created', $wallet->getName()));

                $this->getEm()->commit();
            }catch (\Exception $e) {
                $this->flashError(sprintf('Failed creationg new wallet: %s', $e->getMessage()));

                $this->getEm()->rollback();
                $this->getEm()->close();

                throw $e;
            }

            return $this->redirectToRoute('app_wallet_list');
        }

        return [
            "form" => $form->createView(),
        ];
    }

    /**
     * @Route("/{wallet}/edit", name="app_wallet_edit")
     * @Template()
     *
     * @param Request $request
     * @param Wallet  $wallet
     *
     * @return array|RedirectResponse
     * @throws \Exception
     */
    public function editAction(Request $request, Wallet $wallet)
    {
        $this->denyAccessUnlessGranted('EDIT', $wallet);

        $form = $this->createForm(WalletType::class, $wallet, ['setSettled' => true]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var Wallet $wallet */
            $wallet = $form->getData();

            $this->getEm()->beginTransaction();
            try{
                $this->get('app.service_wallet.wallet_persister')->update($wallet);
                $this->flashNotification(sprintf('Wallet %s successfully modified', $wallet->getName()));

                $this->getEm()->commit();
            }catch (\Exception $e) {
                $this->flashError(sprintf('Failed wallet edit: %s', $e->getMessage()));

                $this->getEm()->rollback();
                $this->getEm()->close();

                throw $e;
            }

            return $this->redirectToRoute('app_wallet_list');
        }

        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Route("/{wallet}/delete", name="app_wallet_delete")
     * @param Wallet $wallet
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(Wallet $wallet)
    {
        $this->denyAccessUnlessGranted('DELETE', $wallet);

        $this->getEm()->beginTransaction();
        try{
            $this->get('app.service_wallet.wallet_persister')->delete($wallet);
            $this->flashNotification(sprintf('Wallet %s successfully deleted', $wallet->getName()));

            $this->getEm()->commit();
        }catch (\Exception $e) {
            $this->flashError(sprintf('Failed wallet deletion: %s', $e->getMessage()));

            $this->getEm()->rollback();
            $this->getEm()->close();

            throw $e;
        }

        return $this->redirectToRoute('app_wallet_list');
    }

}
