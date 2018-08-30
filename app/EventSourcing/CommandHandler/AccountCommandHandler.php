<?php

namespace App\EventSourcing\CommandHandler;

use App\EventSourcing\AggregateRoot\Account;
use App\EventSourcing\Command\AccountCreateCommand;
use App\EventSourcing\Command\AccountDepositCommand;
use App\EventSourcing\Command\AccountTransactionCommand;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\EventSourcing\EventSourcingRepository;

class AccountCommandHandler extends SimpleCommandHandler
{
    /** @var EventSourcingRepository */
    private $repository;

    /**
     * @param EventSourcingRepository $repository
     */
    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handleAccountCreateCommand(AccountCreateCommand $command)
    {
        $account = Account::create($command->accountId, $command->userId);

        $this->repository->save($account);
    }

    protected function handleAccountDepositCommand(AccountDepositCommand $command)
    {
        /** @var Account $account */
        $account = $this->repository->load($command->accountId);

        $account->deposit($command->depositAmount);

        $this->repository->save($account);
    }

    protected function handleAccountTransactionCommand(AccountTransactionCommand $command)
    {
        /** @var Account $account */
        $account = $this->repository->load($command->accountId);

        $account->transaction($command->transactionAmount);

        $this->repository->save($account);
    }
}

