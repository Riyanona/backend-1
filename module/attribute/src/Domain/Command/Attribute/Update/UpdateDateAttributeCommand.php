<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Domain\Command\Attribute\Update;

use Ergonode\Attribute\Domain\Command\Attribute\AbstractUpdateAttributeCommand;
use Ergonode\Attribute\Domain\ValueObject\AttributeScope;
use Ergonode\Attribute\Domain\ValueObject\DateFormat;
use Ergonode\Core\Domain\ValueObject\TranslatableString;
use Ergonode\SharedKernel\Domain\Aggregate\AttributeId;
use JMS\Serializer\Annotation as JMS;

/**
 */
class UpdateDateAttributeCommand extends AbstractUpdateAttributeCommand
{
    /**
     * @var DateFormat
     *
     * @JMS\Type("Ergonode\Attribute\Domain\ValueObject\DateFormat")
     */
    private DateFormat $format;

    /**
     * @param AttributeId        $id
     * @param TranslatableString $label
     * @param TranslatableString $hint
     * @param TranslatableString $placeholder
     * @param AttributeScope     $scope
     * @param DateFormat         $format
     * @param array              $groups
     */
    public function __construct(
        AttributeId $id,
        TranslatableString $label,
        TranslatableString $hint,
        TranslatableString $placeholder,
        AttributeScope $scope,
        DateFormat $format,
        array $groups = []
    ) {
        parent::__construct(
            $id,
            $label,
            $hint,
            $placeholder,
            $scope,
            $groups
        );

        $this->format = $format;
    }

    /**
     * @return DateFormat
     */
    public function getFormat(): DateFormat
    {
        return $this->format;
    }
}
