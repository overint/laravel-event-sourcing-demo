<?php

namespace App\EventSourcing\Event;

class AccountTransactionPerformedEvent extends AccountEvent
{
    public $purchaseAmount;

    public function __construct(string $accountId, float $purchaseAmount)
    {
        $this->accountId = $accountId;
        $this->purchaseAmount = $purchaseAmount;
    }

    public static function deserialize(array $data)
    {
        return new self($data['accountId'], $data['purchaseAmount']);
    }

    public function serialize()
    {
        return [
            'accountId' => $this->accountId,
            'purchaseAmount' => $this->purchaseAmount,
        ];
    }
}


