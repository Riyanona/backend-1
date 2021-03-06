<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Product\Persistence\Dbal\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Ergonode\SharedKernel\Domain\Aggregate\ProductId;
use Ergonode\Product\Domain\Query\ProductBindingQueryInterface;

/**
 */
class DbalProductBindingQuery implements ProductBindingQueryInterface
{
    private const ATTRIBUTE_TABLE = 'public.attribute';
    private const PRODUCT_BINDING_TABLE = 'public.product_binding';

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ProductId $productId
     *
     * @return array
     */
    public function getBindings(ProductId $productId): array
    {
        $qb = $this->getQuery();

        return $qb
            ->select('pb.attribute_id')
            ->where($qb->expr()->eq('pb.product_id', ':id'))
            ->setParameter(':id', $productId->getValue())
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @return QueryBuilder
     */
    private function getQuery(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select('p.id, a.code')
            ->from(self::PRODUCT_BINDING_TABLE, 'pb')
            ->join('pb', self::ATTRIBUTE_TABLE, 'a', 'a.id = pb.attribute_id');
    }
}
