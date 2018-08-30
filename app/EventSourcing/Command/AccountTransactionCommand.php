<?php

namespace App\EventSourcing\Command;

class AccountTransactionCommand extends AccountCommand
{
    public $transactionAmount;

    public function __construct(string $accountId, float $transactionAmount)
    {
        $this->accountId = $accountId;
        $this->transactionAmount = $transactionAmount;
    }


}
