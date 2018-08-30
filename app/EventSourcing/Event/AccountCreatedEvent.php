<?php

namespace App\EventSourcing\Event;

use Broadway\Serializer\Serializable;

class AccountCreatedEvent extends AccountEvent implements Serializable
{
    public $userId;

    public function __construct(string $accountId, string $userId)
    {
        $this->accountId = $accountId;
        $this->userId = $userId;
    }

    public static function deserialize(array $data)
    {
        return new self($data['accountId'], $data['userId']);
    }

    public function serialize()
    {
        return [
            'accountId' => $this->accountId,
            'userId' => $this->userId,
        ];
    }
}


