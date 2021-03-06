<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Exporter\Infrastructure\Handler\Export;

use Ergonode\Exporter\Domain\Command\Export\StartExportCommand;
use Ergonode\Exporter\Domain\Repository\ExportRepositoryInterface;
use Ergonode\Exporter\Infrastructure\Provider\ExportProcessorProvider;
use Webmozart\Assert\Assert;
use Ergonode\Channel\Domain\Repository\ChannelRepositoryInterface;

/**
 */
class StartExportCommandHandler
{
    /**
     * @var ExportRepositoryInterface
     */
    private ExportRepositoryInterface $exportRepository;

    /**
     * @var ChannelRepositoryInterface
     */
    private ChannelRepositoryInterface $channelRepository;

    /**
     * @var ExportProcessorProvider
     */
    private ExportProcessorProvider $provider;

    /**
     * @param ExportRepositoryInterface  $exportRepository
     * @param ChannelRepositoryInterface $channelRepository
     * @param ExportProcessorProvider    $provider
     */
    public function __construct(
        ExportRepositoryInterface $exportRepository,
        ChannelRepositoryInterface $channelRepository,
        ExportProcessorProvider $provider
    ) {
        $this->exportRepository = $exportRepository;
        $this->channelRepository = $channelRepository;
        $this->provider = $provider;
    }

    /**
     * @param StartExportCommand $command
     */
    public function __invoke(StartExportCommand $command)
    {
        $export = $this->exportRepository->load($command->getExportId());
        Assert::notNull($export);
        $channel = $this->channelRepository->load($export->getChannelId());
        Assert::notNull($channel);

        $export->start();
        $this->exportRepository->save($export);

        $processor = $this->provider->provide($channel->getType());
        $processor->start($command->getExportId(), $channel);
    }
}
