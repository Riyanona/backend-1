<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Condition\Infrastructure\Condition\Calculator;

use Ergonode\Attribute\Domain\Repository\AttributeRepositoryInterface;
use Ergonode\Condition\Domain\Condition\NumericAttributeValueCondition;
use Ergonode\Condition\Domain\ConditionInterface;
use Ergonode\Condition\Infrastructure\Condition\ConditionCalculatorStrategyInterface;
use Ergonode\Product\Domain\Entity\AbstractProduct;
use Webmozart\Assert\Assert;

/**
 */
class NumericAttributeValueConditionCalculatorStrategy implements ConditionCalculatorStrategyInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    private AttributeRepositoryInterface $repository;

    /**
     * @param AttributeRepositoryInterface $repository
     */
    public function __construct(AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return NumericAttributeValueCondition::TYPE === $type;
    }

    /**
     * {@inheritDoc}
     */
    public function calculate(AbstractProduct $product, ConditionInterface $configuration): bool
    {
        $attributeId = $configuration->getAttribute();
        $attribute = $this->repository->load($attributeId);
        Assert::notNull($attribute);

        $option = $configuration->getOption();
        $expected = $configuration->getValue();

        if ($product->hasAttribute($attribute->getCode())) {
            $values = $product->getAttribute($attribute->getCode());
            foreach ($values->getValue() as $value) {
                if ($this->calculateValue($option, (float) $expected, (float) $value)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $option
     * @param float  $expected
     * @param float  $value
     *
     * @return bool
     */
    private function calculateValue(string $option, float $expected, float $value): bool
    {
        if (('=' === $option) && $value !== $expected) {
            return false;
        }

        if (('<>' === $option) && $value === $expected) {
            return false;
        }

        if (('>' === $option) && $value <= $expected) {
            return false;
        }

        if (('>=' === $option) && $value < $expected) {
            return false;
        }

        if (('<' === $option) && $value >= $expected) {
            return false;
        }

        if (('<=' === $option) && $value > $expected) {
            return false;
        }

        return true;
    }
}
