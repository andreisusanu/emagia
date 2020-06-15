<?php

namespace Emagia\Hero;

use Emagia\Hero\Property\HeroPropertyConstraint;
use Emagia\Hero\Property\HeroPropertyType;
use Emagia\Hero\Skill\HeroSkillConstraint;

/**
 * Class Beast
 * @package Emagia\Hero
 */
class Beast extends AbstractHero implements HeroInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return HeroType::BEAST;
    }

    /**
     * @return HeroPropertyConstraint[]
     */
    public static function buildPropertiesConstraints(): array
    {
        return [
            new HeroPropertyConstraint(HeroPropertyType::HEALTH, 60, 90, true),
            new HeroPropertyConstraint(HeroPropertyType::STRENGTH, 60, 90, true),
            new HeroPropertyConstraint(HeroPropertyType::DEFENCE, 40, 60, true),
            new HeroPropertyConstraint(HeroPropertyType::SPEED, 40, 60, true),
            new HeroPropertyConstraint(HeroPropertyType::LUCK, 25, 40, true),
        ];
    }

    /**
     * @return HeroSkillConstraint[]
     */
    public static function buildSkillsConstraints(): array
    {
        return [];
    }
}
