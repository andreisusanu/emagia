<?php

namespace Emagia\Hero\Skill;

/**
 * Class HeroSkill
 * @package Emagia\Hero\Skill
 */
class HeroSkill
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $chance;

    /**
     * HeroSkill constructor.
     * @param string $type
     * @param int $chance
     */
    public function __construct(string $type, int $chance)
    {
        $this->type = $type;
        $this->chance = $chance;
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
    public function getChance(): int
    {
        return $this->chance;
    }
}
