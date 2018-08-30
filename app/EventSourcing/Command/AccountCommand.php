<?php

namespace App\EventSourcing\Command;

class AccountCommand
{
    public $accountId;

    public function __construct(string $accountId)
    {
        $this->accountId = $accountId;
    }
}
