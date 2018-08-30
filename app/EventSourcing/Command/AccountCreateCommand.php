<?php

namespace App\EventSourcing\Command;

class AccountCreateCommand extends AccountCommand
{
    public $userId;

    public function __construct(string $accountId, string $userId)
    {
        $this->accountId = $accountId;
        $this->userId = $userId;
    }
}
