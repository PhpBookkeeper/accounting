<?php

declare(strict_types=1);

namespace Bookkeeper\Accounting\Infrastructure\Id\Uuid;

use Bookkeeper\Accounting\Domain\Operation\OperationIdInterface;
use Bookkeeper\Accounting\Domain\Operation\PublicInterface\OperationIdFactoryInterface;

final class OperationIdFactoryUuid implements OperationIdFactoryInterface
{
    private UuidFactory $uuidFactory;

    public function __construct(UuidFactory $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
    }

    public function create(?string $value = null): OperationIdInterface
    {
        return new OperationIdUuid($this->uuidFactory->create($value));
    }
}
