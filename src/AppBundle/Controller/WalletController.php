<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Wallet;
use AppBundle\Form\WalletType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WalletController
 * @Route("/wallet")
 */
class WalletController extends BaseController
{
    /**
     * @Route("/list", name="app_wallet_list")
     * @Template()
     */
    public function listAction()
    {
        return [
            "wallets" => $this->getRepository(Wallet::class)->findAll(),
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
        return [
            "wallet" => $wallet,
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
        $form = $this->createForm(WalletType::class);

        $form->handleRequest($request);

        if ($form->isValid()) {

            /** @var Wallet $wallet */
            $wallet = $form->getData();

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
     * @Route("/edit", name="app_wallet_edit")
     */
    public function editAction()
    {
        return $this->render('AppBundle:Wallet:edit.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/delete", name="app_wallet_delete")
     */
    public function deleteAction()
    {
        return $this->render('AppBundle:Wallet:delete.html.twig', array(
            // ...
        ));
    }

}
