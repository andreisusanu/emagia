<?php

namespace Emagia\Hero\Validator;

use Emagia\Hero\Exception\HeroValidationException;
use Emagia\Hero\HeroInterface;

/**
 * Class HeroValidator
 * @package Emagia\Hero\Validator
 */
class HeroValidator
{
    /**
     * @param HeroInterface $hero
     * @throws HeroValidationException
     */
    public function validateHero(HeroInterface $hero)
    {
        $this->validatePropertiesConstraints($hero);
        $this->validateSkillsConstraints($hero);
    }

    /**
     * @param HeroInterface $hero
     * @throws HeroValidationException
     */
    private function validatePropertiesConstraints(HeroInterface $hero)
    {
        foreach ($hero->getPropertiesConstraints() as $propertiesConstraint) {
            $property = $hero->getProperty($propertiesConstraint->getType());

            if ($propertiesConstraint->isRequired() && empty($property)) {
                throw new HeroValidationException('Missing mandatory property: ' . $propertiesConstraint->getType());
            }

            if (!empty($property)) {
                if ($property->getValue() < $propertiesConstraint->getMinValue()) {
                    throw new HeroValidationException(
                        'Invalid value for property: ' . $property->getType() . ' = ' . $property->getValue() .
                        '. Minimum allowed value is ' . $propertiesConstraint->getMinValue()
                    );
                }

                if ($property->getValue() > $propertiesConstraint->getMaxValue()) {
                    throw new HeroValidationException(
                        'Invalid value for property: ' . $property->getType() . ' = ' . $property->getValue() .
                        '. Maximum allowed value is ' . $propertiesConstraint->getMaxValue()
                    );
                }
            }
        }
    }

    /**
     * @param HeroInterface $hero
     * @throws HeroValidationException
     */
    private function validateSkillsConstraints(HeroInterface $hero)
    {
        foreach ($hero->getSkillsConstraints() as $skillsConstraint) {
            $skill = $hero->getSkill($skillsConstraint->getType());

            if (!empty($skill)) {
                if ($skill->getChance() < $skillsConstraint->getMinChanceValue()) {
                    throw new HeroValidationException(
                        'Invalid value for skill: ' . $skill->getType() . ' = ' . $skill->getChance() .
                        '. Minimum allowed value is ' . $skillsConstraint->getMinChanceValue()
                    );
                }

                if ($skill->getChance() > $skillsConstraint->getMaxChanceValue()) {
                    throw new HeroValidationException(
                        'Invalid value for skill: ' . $skill->getType() . ' = ' . $skill->getChance() .
                        '. Maximum allowed value is ' . $skillsConstraint->getMaxChanceValue()
                    );
                }
            }
        }
    }
}
