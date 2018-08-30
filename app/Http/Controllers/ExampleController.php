<?php

namespace App\Http\Controllers;

use App\EventSourcing\Command\AccountCreateCommand;
use App\EventSourcing\Command\AccountDepositCommand;
use App\EventSourcing\Command\AccountTransactionCommand;
use App\EventSourcing\CommandHandler\AccountCommandHandler;
use App\EventSourcing\Repository\AccountRepository;
use Broadway\CommandHandling\SimpleCommandBus;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /** @var AccountRepository */
    private $accountRepository;
    /** @var SimpleCommandBus */
    private $commandBus;

    /**
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;

        $accountCommandHandler = new AccountCommandHandler($this->accountRepository);

        $this->commandBus = new SimpleCommandBus();
        $this->commandBus->subscribe($accountCommandHandler);
    }

    public function index()
    {
        return view('index');
    }

    /**
     * @throws \Exception
     */
    public function create()
    {
        // Create a new account
        $id = (new Version4Generator())->generate();
        $createCommand = new AccountCreateCommand($id, 123);
        $this->commandBus->dispatch($createCommand);

        // Deposit into the account
        $depositCommandOne = new AccountDepositCommand($id, 44.22);
        $this->commandBus->dispatch($depositCommandOne);
        $depositCommandTwo = new AccountDepositCommand($id, 100);
        $this->commandBus->dispatch($depositCommandTwo);

        // Make a purchase
        $txCommand = new AccountTransactionCommand($id, 24.99);
        $this->commandBus->dispatch($txCommand);

        return redirect()->route('view', [$id]);
    }

    public function view($id)
    {
        $entity = $this->accountRepository->load($id);

        return view('view', compact('entity'));
    }

    public function buy(Request $request, $id)
    {
        $txCommand = new AccountTransactionCommand($id, $request->get('amount'));
        $this->commandBus->dispatch($txCommand);

        return redirect()->route('view', [$id]);
    }
}
