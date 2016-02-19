<?php

namespace Hackathon\LevelD;

class Bobby
{
    public $wallet = array();
    public $total;

    public function __construct($wallet)
    {
        $this->wallet = $wallet;
        $this->computeTotal();
    }

    /**
     * @TODO
     *
     * @param $price
     *
     * @return bool|int|string
     */
    public function giveMoney($price)
    {
        $walletTmp = array();

        foreach ($this->wallet as $money) {
            if (is_numeric($money)) {
                if (!array_key_exists($money, $walletTmp)) {
                    $walletTmp[$money] = 1;
                } else {
                    ++$walletTmp[$money];
                }
            }
        }

        krsort($walletTmp);

        $billetsToRemove = array();
        foreach ($walletTmp as $value => $total) {
            for ($i = 0; $i < $total; $i++) {
                $price = $price - $value;

                $billetsToRemove[] = $value;

                if ($price <= 0) {
                    break 2;
                }
            }
        }

        $tmpTotal = $this->total;
        $backupWallet = $this->wallet;

        foreach ($billetsToRemove as $billetToRemove) {
            $pouetWallet = $this->wallet;

            foreach ($pouetWallet as $key => $value) {
                if ($billetToRemove == $value) {
                    $tmpTotal = $tmpTotal - $value;

                    unset($pouetWallet[$key]);

                    break;
                }
            }

            $this->wallet = $pouetWallet;
        }

        if ($tmpTotal > 0) {
            $this->total = $tmpTotal;
        } else {
            $this->wallet = $backupWallet;

            return false;
        }

        $countResultInt = false;
        foreach ($this->wallet as $wallet) {
            if (is_numeric($wallet)) {
                $countResultInt = true;
                break;
            }
        }

        return $countResultInt;
    }

    /**
     * This function updates the amount of your wallet
     */
    private function computeTotal()
    {
        $this->total = 0;

        foreach ($this->wallet as $element) {
            if (is_numeric($element)) {
                $this->total += $element;
            }
        }
    }
}
