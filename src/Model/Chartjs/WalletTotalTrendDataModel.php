<?php declare(strict_types=1);

namespace App\Model\Chartjs;

use App\Entity\MonthlyWallet;
use App\Entity\Wallet;

/**
 * Class WalletTotalTrendDataModel.
 */
class WalletTotalTrendDataModel
{
    /** @var string[] */
    private $labels;

    /** @var int[] */
    private $data;

    /**
     * WalletTotalTrendDataModel constructor.
     *
     * @param array $labels
     * @param array $data
     */
    public function __construct(array $labels = ["Undefined"], array $data = [0])
    {
        $this->labels = $labels;
        $this->data = $data;
    }

    /**
     * @param array|Wallet[] $wallets
     *
     * @return WalletTotalTrendDataModel
     */
    public static function  buildWithWalletList(array $wallets): WalletTotalTrendDataModel
    {
        $labels = [];
        $data = [];
        /** @var MonthlyWallet $wallet */
        foreach ($wallets as $wallet) {
            $labels[] = $wallet->getReferenceMonth('M y');
            $data[] = abs((int)$wallet->getTransactionsTotalAmount());
        }

        return new static($labels, $data);
    }

    /**
     * @return \string[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @return \int[]
     */
    public function getData(): array
    {
        return $this->data;
    }
}
