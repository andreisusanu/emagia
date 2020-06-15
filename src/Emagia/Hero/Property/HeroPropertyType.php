<?php

namespace Emagia\Hero\Property;

/**
 * Class HeroPropertyType
 * @package Emagia\Hero\Property
 */
class HeroPropertyType
{
    const HEALTH = 'Health';
    const STRENGTH = 'Strength';
    const DEFENCE = 'Defence';
    const SPEED = 'Speed';
    const LUCK = 'Luck';

    /**
     * @return array
     */
    public static function toArray()
    {
        return [
            self::HEALTH,
            self::STRENGTH,
            self::DEFENCE,
            self::SPEED,
            self::LUCK
        ];
    }
}
