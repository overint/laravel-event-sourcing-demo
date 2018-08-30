<?php

namespace App\EventSourcing\Repository;

use App\EventSourcing\AggregateRoot\Account;
use Broadway\Domain\DomainEventStream;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class AccountRepository extends EventSourcingRepository
{
    protected $eventStore;

    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        $this->eventStore = $eventStore;

        parent::__construct($eventStore, $eventBus, Account::class, new PublicConstructorAggregateFactory());
    }

    public function append($id, DomainEventStream $eventStream)
    {
        $this->eventStore->append($id, $eventStream);
    }
}
