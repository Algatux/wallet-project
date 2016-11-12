<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\Wallet;
use AppBundle\Form\TransactionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TransactionController
 *
 * @Route("/transaction")
 */
class TransactionController extends BaseController
{
    /**
     * @Route("/{wallet}/add")
     * @Template()
     *
     * @param Request $request
     * @param Wallet  $wallet
     *
     * @return array|RedirectResponse
     */
    public function addAction(Request $request, Wallet $wallet)
    {
        $form = $this->createForm(TransactionType::class);

        $form->handleRequest($request);

        if ($form->isValid()) {

            /** @var Transaction $transaction */
            $transaction = $form->getData();
            $transaction->setTransactedBy($this->getUser());

            $this->getEm()->beginTransaction();
            try{

                $this
                    ->get('app.service_transaction.transaction_persister')
                    ->persistOnWallet($transaction, $wallet);

                $this->flashNotification('Transaction sucessfully added.');

                $this->getEm()->commit();
            } catch (\Exception $e)
            {
                $this->getEm()->rollback();
                $this->getEm()->close();

                $this->flashError('Error saving transaction: '.$e->getMessage());
            }

            return $this->redirectToRoute('app_wallet_detail', ["wallet" => $wallet->getId()]);
        }

        return [
            "form" => $form->createView(),
        ];
    }

    /**
     * @Route("/transaction/{transaction}/remove")
     *
     * @param Transaction $transaction
     *
     * @return RedirectResponse
     */
    public function removeAction(Transaction $transaction)
    {
        $redirect = $this->redirectToRoute('app_wallet_detail', ["wallet" => $transaction->getWallet()->getId()]);

        $this->getEm()->beginTransaction();

        try{

            $this
                ->get('app.service_transaction.transaction_persister')
                ->delete($transaction);

            $this->flashNotification('Transaction sucessfully deleted.');

            $this->getEm()->commit();
        } catch (\Exception $e)
        {
            $this->getEm()->rollback();
            $this->getEm()->close();

            $this->flashError('Error deleting transaction: '.$e->getMessage());
        }

        return $redirect;
    }

}
