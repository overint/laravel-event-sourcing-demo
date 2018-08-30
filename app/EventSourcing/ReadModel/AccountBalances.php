<?php

namespace App\EventSourcing\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class AccountBalances implements SerializableReadModel
{
    private $accountId;
    private $userId;
    private $balance = 0;

    public function __construct($accountId, $userId)
    {
        $this->accountId = $accountId;
        $this->userId = $userId;
    }

    public function getId()
    {
        return $this->accountId;
    }

    public static function deserialize(array $data)
    {
        return new self($data['accountId'], $data['userId']);
    }

    public function serialize()
    {
        return get_object_vars($this);
    }

    public function deposit($depositAmount)
    {
        $this->balance = $this->balance + $depositAmount;
    }

    public function transaction($purchaseAmount)
    {
        $this->balance = $this->balance + $purchaseAmount;
    }
}
