<?php

namespace Emagia\Hero;

use Emagia\Hero\Exception\HeroException;
use Emagia\Hero\Property\HeroProperty;
use Emagia\Hero\Skill\HeroSkill;

/**
 * Class HeroFactory
 * @package Emagia\Hero
 */
class HeroFactory
{
    /**
     * @param string $name
     * @param string $type
     * @param HeroProperty[] $properties
     * @param HeroSkill[] $skills
     * @return HeroInterface
     * @throws HeroException
     */
    public static function make(string $name, string $type, array $properties, array $skills): HeroInterface
    {
        switch ($type) {
            case HeroType::ORDERUS:
                return new Orderus($name, $properties, $skills);
                break;
            case HeroType::BEAST:
                return new Beast($name, $properties, $skills);
                break;
            default:
                throw new HeroException('Unknown hero type: ' . $type);
        }
    }
}
