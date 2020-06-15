<?php

namespace Emagia\Hero\Property;

/**
 * Class HeroPropertyConstraint
 * @package Emagia\Hero\Property
 */
class HeroPropertyConstraint
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $minValue;

    /**
     * @var int
     */
    private $maxValue;

    /**
     * @var bool
     */
    private $required;

    /**
     * HeroPropertyConstraint constructor.
     * @param string $type
     * @param int $minValue
     * @param int $maxValue
     * @param bool $required
     */
    public function __construct(string $type, int $minValue, int $maxValue, bool $required)
    {
        $this->type = $type;
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->required = $required;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getMinValue(): int
    {
        return $this->minValue;
    }

    /**
     * @return int
     */
    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}
