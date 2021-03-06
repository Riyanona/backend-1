<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Exporter\Persistence\Dbal\Repository\Factory;

use Ergonode\Exporter\Domain\Entity\Export;
use Ergonode\Exporter\Domain\ValueObject\ExportStatus;
use Ergonode\SharedKernel\Domain\Aggregate\ChannelId;
use Ergonode\SharedKernel\Domain\Aggregate\ExportId;

/**
 */
class ExportFactory
{
    /**
     * @param array $record
     *
     * @return Export
     *
     * @throws \ReflectionException
     */
    public function create(array $record): Export
    {
        $reflector = new \ReflectionClass(Export::class);
        /** @var Export $object */
        $object = $reflector->newInstanceWithoutConstructor();

        foreach ($this->getMap($record) as $key => $value) {
            $property = $reflector->getProperty($key);
            $property->setAccessible(true);
            $property->setValue($object, $value);
        }

        return $object;
    }

    /**
     * @param array $record
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getMap(array $record): array
    {
        return [
            'id' => new ExportId($record['id']),
            'status' => new ExportStatus($record['status']),
            'channelId' => new ChannelId($record['channel_id']),
            'items' => $record['items'],
            'startedAt' => $record['started_at'] ? new \DateTime($record['started_at']) : null,
            'endedAt' => $record['ended_at'] ? new \DateTime($record['ended_at']) : null,
        ];
    }
}
