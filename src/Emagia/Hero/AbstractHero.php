<?php

namespace Emagia\Hero;

use Emagia\Hero\Property\HeroProperty;
use Emagia\Hero\Property\HeroPropertyConstraint;
use Emagia\Hero\Property\HeroPropertyType;
use Emagia\Hero\Skill\HeroSkill;
use Emagia\Hero\Skill\HeroSkillConstraint;

/**
 * Class AbstractHero
 * @package Emagia\Hero
 */
abstract class AbstractHero
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var HeroProperty[]
     */
    private $properties;

    /**
     * @var HeroPropertyConstraint[]
     */
    private $propertiesConstraints;

    /**
     * @var HeroSkill[]
     */
    private $skills;

    /**
     * AbstractHero constructor.
     * @param string $name
     * @param HeroProperty[] $properties
     * @param HeroSkill[] $skills
     */
    public function __construct(string $name, array $properties, array $skills)
    {
        $this->name = $name;
        $this->properties = $properties;
        $this->skills = $skills;
        $this->propertiesConstraints = static::buildPropertiesConstraints();
        $this->skillsConstrants = static::buildSkillsConstraints();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return HeroProperty[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $type
     * @return HeroProperty|null
     */
    public function getProperty(string $type)
    {
        foreach ($this->getProperties() as $heroProperty) {
            if ($type === $heroProperty->getType()) {
                return $heroProperty;
            }
        }

        return null;
    }

    /**
     * @return HeroPropertyConstraint[]
     */
    public function getPropertiesConstraints(): array
    {
        return $this->propertiesConstraints;
    }

    /**
     * @return HeroPropertyConstraint[]
     */
    public static abstract function buildPropertiesConstraints(): array;

    /**
     * @return HeroSkill[]
     */
    public function getSkills(): array
    {
        return $this->skills;
    }

    /**
     * @param string $type
     * @return HeroSkill|null
     */
    public function getSkill(string $type)
    {
        foreach ($this->getSkills() as $heroSkill) {
            if ($type === $heroSkill->getType()) {
                return $heroSkill;
            }
        }

        return null;
    }

    /**
     * @return HeroSkillConstraint[]
     */
    public function getSkillsConstraints(): array
    {
        return $this->skillsConstrants;
    }

    /**
     * @return HeroSkillConstraint[]
     */
    public static abstract function buildSkillsConstraints(): array;

    /**
     * @param int $value
     */
    public function createDamage(int $value)
    {
        $healthProperty = $this->getProperty(HeroPropertyType::HEALTH);

        if (is_null($healthProperty)) {
            return;
        }

        $healthProperty->setValue($healthProperty->getValue() - $value);
    }
}
