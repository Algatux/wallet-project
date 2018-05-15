<?php declare(strict_types=1);

namespace ApiBundle\Service\Serializer\Handler;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use AppBundle\Entity\MonthlyWallet as Wallet;

class MonthlyWalletHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'AppBundle\\Entity\\MonthlyWallet',
                'method' => 'serialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Wallet $wallet, array $type, Context $context)
    {
        return [
            'id' => $wallet->getId(),
            'name' => $wallet->getName(),
            'description' => $wallet->getDescription(),
            'settled' => $wallet->isSettled(),

            'transactions' => $wallet->getTransactions()->map(function(Transaction $t){return $t->getId();})->toArray(),
            'owner' => $visitor->getNavigator()->accept($wallet->getOwner(),['name' => User::class], $context),
            'sharedWith' => $wallet->getSharedWith()->map(function(User $user) use ($visitor, $context) {
                return $visitor->getNavigator()->accept($user,['name' => User::class], $context);
            })->toArray(),
        ];
    }
}