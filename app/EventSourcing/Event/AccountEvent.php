<?php

namespace App\EventSourcing\Event;

use Broadway\Serializer\Serializable;

abstract class AccountEvent implements Serializable
{
    public $accountId;

    public function __construct(string $accountId)
    {
        $this->accountId = $accountId;
    }
}
