<?php

namespace Emagia\Hero;

/**
 * Class HeroType
 * @package Emagia\Hero
 */
class HeroType
{
    const ORDERUS = 'Orderus';
    const BEAST = 'Beast';

    /**
     * @return array
     */
    public static function toArray()
    {
        return [
            self::ORDERUS,
            self::BEAST
        ];
    }
}
