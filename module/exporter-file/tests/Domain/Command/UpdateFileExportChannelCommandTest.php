<?php
/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\ExporterFile\Tests\Domain\Command;

use Ergonode\ExporterFile\Domain\Command\UpdateFileExportChannelCommand;
use PHPUnit\Framework\TestCase;
use Ergonode\SharedKernel\Domain\Aggregate\ChannelId;

/**
 */
class UpdateFileExportChannelCommandTest extends TestCase
{
    /**
     */
    public function testCommand(): void
    {
        $id = $this->createMock(ChannelId::class);
        $name = 'Name';
        $format = 'Format';
        $command = new UpdateFileExportChannelCommand($id, $name, $format);
        self::assertEquals($id, $command->getId());
        self::assertEquals($name, $command->getName());
        self::assertEquals($format, $command->getFormat());
    }
}
