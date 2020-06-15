<?php

namespace Emagia\Hero\Skill;

/**
 * Class HeroSkillConstraint
 * @package Emagia\Hero\Skill
 */
class HeroSkillConstraint
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $minChanceValue;

    /**
     * @var int
     */
    private $maxChanceValue;

    /**
     * HeroSkillConstraint constructor.
     * @param string $type
     * @param int $minChanceValue
     * @param int $maxChanceValue
     */
    public function __construct(string $type, int $minChanceValue, int $maxChanceValue)
    {
        $this->type = $type;
        $this->minChanceValue = $minChanceValue;
        $this->maxChanceValue = $maxChanceValue;
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
    public function getMinChanceValue()
    {
        return $this->minChanceValue;
    }

    /**
     * @return int
     */
    public function getMaxChanceValue()
    {
        return $this->maxChanceValue;
    }
}
