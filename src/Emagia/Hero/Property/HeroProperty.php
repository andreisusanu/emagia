<?php

namespace Emagia\Hero\Property;

/**
 * Class HeroProperty
 * @package Emagia\Hero\Property
 */
class HeroProperty
{
    /**
     * HeroProperty constructor.
     * @param string $type
     * @param int $value
     */
    public function __construct(string $type, int $value)
    {
        $this->type = $type;
        $this->value = $value;
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
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
