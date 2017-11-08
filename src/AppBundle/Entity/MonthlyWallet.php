<?php declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class MonthlyWallet extends Wallet
{
    public function __construct()
    {
        parent::__construct();
        $this->setReferenceMonth(date('ym'));
    }

    /**
     * @var string
     *
     * @ORM\Column(name="referenceMonth", type="string", length=4, nullable=false)
     * @Assert\NotNull()
     * @Assert\Length(min = 4, max = 4)
     */
    private $referenceMonth;

    public function getReferenceMonth(string $format = null): string
    {
        if (null !== $format) {
            return \DateTime::createFromFormat(
                'ymd his',
                $this->referenceMonth . '01 000000' // firstday at midnight
            )->format($format);
        }

        return $this->referenceMonth;
    }

    public function setReferenceMonth(string $referenceMonth)
    {
        $this->referenceMonth = $referenceMonth;
    }
}
