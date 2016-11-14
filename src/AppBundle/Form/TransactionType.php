<?php

namespace AppBundle\Form;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use AppBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Wallet $wallet */
        $wallet = $options['wallet'];
        $transactedBy = [
            $wallet->getOwner()->getNickName() => $wallet->getOwner(),
        ];

        /** @var User $user */
        foreach ($wallet->getSharedWith() as $user) {
            $transactedBy[$user->getNickName()] = $user;
        }

        $builder
            ->add(
                'motivation',
                TextType::class,
                [
                    "label" => "Transaction Motivation",
                ]
            )
            ->add(
                'amount',
                NumberType::class,
                [
                    "label" => "Money Amount",
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    "label" => "Transaction type",
                    "choices" => [
                        "MoneyOut"  => Transaction::TYPE_OUT,
                        "MoneyIn"   => Transaction::TYPE_IN,
                    ],
                ]
            )
            ->add(
                'transactedBy',
                EntityType::class,
                [
                    "class" => User::class,
                    "choices" => $transactedBy,
                    "choice_label" => "nickName",
                    "label" => "Transacted by",
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    "label" => "Create",
                ]
            );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class,
            'wallet' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_transaction';
    }


}
