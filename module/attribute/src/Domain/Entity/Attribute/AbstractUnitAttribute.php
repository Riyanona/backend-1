<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Domain\Entity\Attribute;

use Ergonode\Attribute\Domain\Entity\AbstractAttribute;
use Ergonode\Attribute\Domain\Event\Attribute\AttributeStringParameterChangeEvent;
use Ergonode\Attribute\Domain\ValueObject\AttributeCode;
use Ergonode\Attribute\Domain\ValueObject\AttributeScope;
use Ergonode\Core\Domain\ValueObject\TranslatableString;
use Ergonode\SharedKernel\Domain\Aggregate\AttributeId;
use Ergonode\SharedKernel\Domain\Aggregate\UnitId;
use JMS\Serializer\Annotation as JMS;

/**
 */
abstract class AbstractUnitAttribute extends AbstractAttribute
{
    public const TYPE = 'UNIT';
    public const UNIT = 'unit';

    /**
     * @param AttributeId        $id
     * @param AttributeCode      $code
     * @param TranslatableString $label
     * @param TranslatableString $hint
     * @param TranslatableString $placeholder
     * @param AttributeScope     $scope
     * @param UnitId             $unitId
     *
     * @throws \Exception
     */
    public function __construct(
        AttributeId $id,
        AttributeCode $code,
        TranslatableString $label,
        TranslatableString $hint,
        TranslatableString $placeholder,
        AttributeScope $scope,
        UnitId $unitId
    ) {
        parent::__construct(
            $id,
            $code,
            $label,
            $hint,
            $placeholder,
            $scope,
            [self::UNIT => $unitId->getValue()]
        );
    }

    /**
     * @JMS\VirtualProperty();
     * @JMS\SerializedName("type")
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return UnitId
     */
    public function getUnitId(): UnitId
    {
        return new UnitId($this->getParameter(self::UNIT));
    }

    /**
     * @param UnitId $new
     *
     * @throws \Exception
     */
    public function changeUnit(UnitId $new): void
    {
        if ($this->getUnitId()->getValue() !== $new->getValue()) {
            $event = new AttributeStringParameterChangeEvent(
                $this->id,
                self::UNIT,
                $this->getUnitId()->getValue(),
                $new->getValue()
            );
            $this->apply($event);
        }
    }
}
