<?php

declare(strict_types=1);

namespace Bookkeeper\Accounting\Domain\Operation;

use Bookkeeper\Accounting\Domain\Operation\OperationService\OperationService;
use Bookkeeper\Accounting\Domain\Operation\Transaction\Transaction;
use Bookkeeper\Accounting\Domain\Operation\Transaction\TransactionIdFactoryInterface;
use DateTimeImmutable;

/**
 * @internal Don't use it directly, use {@see OperationService::create()} instead
 */
final class OperationFactory
{
    private OperationIdFactoryInterface $operationIdFactory;
    private TransactionIdFactoryInterface $transactionIdFactory;

    public function __construct(
        OperationIdFactoryInterface $operationIdFactory,
        TransactionIdFactoryInterface $transactionIdFactory
    ) {
        $this->operationIdFactory = $operationIdFactory;
        $this->transactionIdFactory = $transactionIdFactory;
    }

    public function create(TransactionCreationData ...$transactionData): Operation
    {
        $time = new DateTimeImmutable();
        $transactions = [];
        foreach ($transactionData as $data) {
            $transactions[] = new Transaction(
                $this->transactionIdFactory->create(),
                $data->getCreditAccountId(),
                $data->getDebitAccountId(),
                $data->getAmount(),
                $time
            );
        }

        return new Operation($this->operationIdFactory->create(), $time, ...$transactions);
    }
}
