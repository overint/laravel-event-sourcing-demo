<?php

namespace App\EventSourcing\ReadModel;

use App\EventSourcing\Event\AccountCreatedEvent;
use App\EventSourcing\Event\AccountDepositPerformedEvent;
use App\EventSourcing\Event\AccountTransactionPerformedEvent;
use App\EventSourcing\Repository\AccountRepository;
use Broadway\ReadModel\Projector;

class AccountBalancesProjector extends Projector
{
    /** @var AccountRepository */
    private $repository;

    /**
     * @param AccountRepository $repository
     */
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyAccountCreatedEvent(AccountCreatedEvent $event)
    {
        try {
            $readModel = $this->getReadModel($event->accountId);
        } catch (\Exception $e) {
            $readModel = new AccountBalances($event->accountId, $event->userId);
        }
        $this->repository->save($readModel);
    }

    public function applyAccountDepositPerformedEvent(AccountDepositPerformedEvent $event)
    {
        /** @var AccountBalances $readModel */
        $readModel = $this->getReadModel($event->accountId);

        $readModel->deposit($event->depositAmount);

        $this->repository->save($readModel);
    }

    public function applyAccountTransactionPerformedEvent(AccountTransactionPerformedEvent $event)
    {
        /** @var AccountBalances $readModel */
        $readModel = $this->getReadModel($event->accountId);

        $readModel->transaction($event->purchaseAmount);

        $this->repository->save($readModel);
    }

    public function getReadModel($accountId)
    {
        return $this->repository->find($accountId);
    }
}
