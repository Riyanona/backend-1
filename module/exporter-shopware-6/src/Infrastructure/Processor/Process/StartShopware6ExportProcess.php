<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterShopware6\Infrastructure\Processor\Process;

use Ergonode\ExporterShopware6\Infrastructure\Synchronizer\SynchronizerInterface;
use Ergonode\SharedKernel\Domain\Aggregate\ExportId;
use Ergonode\ExporterShopware6\Domain\Entity\Shopware6Channel;

/**
 */
class StartShopware6ExportProcess
{
    /**
     * @var SynchronizerInterface[]
     */
    private array $synchronizerCollection;

    /**
     * @param SynchronizerInterface ...$synchronizerCollection
     */
    public function __construct(SynchronizerInterface ...$synchronizerCollection)
    {
        $this->synchronizerCollection = $synchronizerCollection;
    }

    /**
     * @param ExportId         $id
     * @param Shopware6Channel $channel
     */
    public function process(ExportId $id, Shopware6Channel $channel): void
    {
        foreach ($this->synchronizerCollection as $synchronizer) {
            $synchronizer->synchronize($id, $channel);
        }
    }
}
