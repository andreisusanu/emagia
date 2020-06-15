<?php

namespace Emagia\Hero;

use Emagia\Hero\Property\HeroPropertyConstraint;
use Emagia\Hero\Property\HeroPropertyType;
use Emagia\Hero\Skill\HeroSkillConstraint;
use Emagia\Hero\Skill\HeroSkillType;

/**
 * Class Orderus
 * @package Emagia\Hero
 */
class Orderus extends AbstractHero implements HeroInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return HeroType::ORDERUS;
    }

    /**
     * @return HeroPropertyConstraint[]
     */
    public static function buildPropertiesConstraints(): array
    {
        return [
            new HeroPropertyConstraint(HeroPropertyType::HEALTH, 70, 100, true),
            new HeroPropertyConstraint(HeroPropertyType::STRENGTH, 70, 80, true),
            new HeroPropertyConstraint(HeroPropertyType::DEFENCE, 45, 55, true),
            new HeroPropertyConstraint(HeroPropertyType::SPEED, 40, 50, true),
            new HeroPropertyConstraint(HeroPropertyType::LUCK, 10, 30, true),
        ];
    }

    /**
     * @return HeroSkillConstraint[]
     */
    public static function buildSkillsConstraints(): array
    {
        return [
            new HeroSkillConstraint(HeroSkillType::RAPID_STRIKE, 10, 10),
            new HeroSkillConstraint(HeroSkillType::MAGIC_SHIELD, 20, 20),
        ];
    }
}
