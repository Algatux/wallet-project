<?php

declare(strict_types=1);

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class WalletType
 */
class WalletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    "label" => "Name"
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    "label" => "Description"
                ]
            )
            ->add(
                'owner',
                EntityType::class,
                [
                    "class" => User::class,
                    "disabled" => true,
                ]
            )
//            ->add(
//                "sharedWith",
//                Form,
//                [
//                    "entry_type" => WalletSharedWithUserType::class,
//                    "required" => false,
//                    "by_reference" => false,
//                ]
//            )
            ->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Wallet::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_wallet';
    }


}
