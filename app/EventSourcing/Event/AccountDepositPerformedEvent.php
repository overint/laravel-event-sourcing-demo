<?php

namespace App\EventSourcing\Event;

class AccountDepositPerformedEvent extends AccountEvent
{
    public $depositAmount;

    public function __construct(string $accountId, float $purchaseAmount)
    {
        $this->accountId = $accountId;
        $this->depositAmount = $purchaseAmount;
    }

    public static function deserialize(array $data)
    {
        return new self($data['accountId'], $data['depositAmount']);
    }

    public function serialize()
    {
        return [
            'accountId' => $this->accountId,
            'depositAmount' => $this->depositAmount,
        ];
    }
}


