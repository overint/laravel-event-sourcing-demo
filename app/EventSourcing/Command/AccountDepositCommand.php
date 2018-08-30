<?php

namespace App\EventSourcing\Command;

class AccountDepositCommand extends AccountCommand
{
    public $depositAmount;

    public function __construct(string $accountId, float $depositAmount)
    {
        $this->accountId = $accountId;
        $this->depositAmount = $depositAmount;
    }
}
