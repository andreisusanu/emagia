<?php

namespace Emagia\Hero;

use Emagia\Hero\Property\HeroProperty;
use Emagia\Hero\Property\HeroPropertyConstraint;
use Emagia\Hero\Skill\HeroSkill;
use Emagia\Hero\Skill\HeroSkillConstraint;

/**
 * Interface HeroInterface
 * @package Emagia\Hero
 */
interface HeroInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return HeroProperty[]
     */
    public function getProperties(): array;

    /**
     * @param string $type
     * @return HeroProperty|null
     */
    public function getProperty(string $type);

    /**
     * @return HeroPropertyConstraint[]
     */
    public function getPropertiesConstraints(): array;

    /**
     * @return HeroPropertyConstraint[]
     */
    public static function buildPropertiesConstraints(): array;

    /**
     * @return HeroSkill[]
     */
    public function getSkills(): array;

    /**
     * @param string $type
     * @return HeroSkill|null
     */
    public function getSkill(string $type);

    /**
     * @return HeroSkillConstraint[]
     */
    public function getSkillsConstraints(): array;

    /**
     * @return HeroSkillConstraint[]
     */
    public static function buildSkillsConstraints(): array;

    /**
     * @param int $value
     * @return void
     */
    public function createDamage(int $value);
}
