<?php

namespace App\EventSourcing\AggregateRoot;

use App\EventSourcing\Event\AccountCreatedEvent;
use App\EventSourcing\Event\AccountDepositPerformedEvent;
use App\EventSourcing\Event\AccountTransactionPerformedEvent;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Account extends EventSourcedAggregateRoot
{
    private $accountId;

    private $userId;
    private $balance = 0;

    /**
     * Factory method to create an account.
     *
     * @param string $accountId
     * @param string $userId
     *
     * @return Account
     */
    public static function create(string $accountId, string $userId)
    {
        $account = new self();
        $account->apply(new AccountCreatedEvent($accountId, $userId));

        return $account;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    public function getAggregateRootId()
    {
        return $this->accountId;
    }

    public function deposit(float $amount)
    {
        if ($amount <= 0) {
            throw new \RuntimeException('Cannot deposit negative amount');
        }

        $this->apply(new AccountDepositPerformedEvent($this->accountId, $amount));
    }

    public function transaction($amount)
    {
        if ($amount > $this->balance) {
            throw new \RuntimeException('Cannot withdraw more than balance');
        }

        $this->apply(new AccountTransactionPerformedEvent($this->accountId, $amount));
    }

    protected function applyAccountCreatedEvent(AccountCreatedEvent $event)
    {
        $this->accountId = $event->accountId;
        $this->userId = $event->userId;
    }

    protected function applyAccountDepositPerformedEvent(AccountDepositPerformedEvent $event)
    {
        $this->balance = $this->balance + $event->depositAmount;
    }

    protected function applyAccountTransactionPerformedEvent(AccountTransactionPerformedEvent $event)
    {
        $this->balance =  $this->balance - $event->purchaseAmount;
    }
}
