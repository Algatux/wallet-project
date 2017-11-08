<?php declare(strict_types=1);

namespace AppBundle\Form;

use AppBundle\Entity\MonthlyWallet;
use AppBundle\Entity\User;
use AppBundle\Entity\Wallet;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
        $owner = $this->retrieveWalletOwner($options);

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
            ->add(
                'settled',
                CheckboxType::class,
                [
                    'label' => 'saldato',
                    'required' => false,
                    "disabled" => !$options['setSettled'],
                ]
            )
            ->add(
                "sharedWith",
                EntityType::class,
                [
                    "class" => User::class,
                    "multiple" => true,
                    "expanded" => true,
                    "required" => false,
                    "by_reference" => false,
                    "query_builder" => function (EntityRepository $repository) use ($owner)
                    {
                        $qb = $repository->createQueryBuilder('u');

                        if ($owner instanceof User) {
                            $qb->andWhere('u.id != :ownerId');
                            $qb->setParameter('ownerId', $owner->getId());
                        }

                        $qb->andWhere('u.hidden = false');
                        $qb->orderBy('u.nickName','ASC');

                        return $qb;
                    }
                ]
            )
            ->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Wallet::class,
            'owner' => null,
            'setSettled' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_wallet';
    }

    /**
     * @param array $options
     *
     * @return User
     */
    private function retrieveWalletOwner(array $options): User
    {
        /** @var Wallet $wallet */
        $wallet = $options['data'] ?? new MonthlyWallet();
        /** @var User $owner */
        return !$wallet->getOwner() instanceof User ? $options['owner'] : $wallet->getOwner();
    }
}
