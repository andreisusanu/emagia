<?php

namespace Emagia\Hero\Skill;

/**
 * Class HeroSkillType
 * @package Emagia\Hero\Skill
 */
class HeroSkillType
{
    const RAPID_STRIKE = 'Rapid strike';
    const MAGIC_SHIELD = 'Magic shield';

    /**
     * @return array
     */
    public static function toArray()
    {
        return [
            self::RAPID_STRIKE,
            self::MAGIC_SHIELD
        ];
    }
}
