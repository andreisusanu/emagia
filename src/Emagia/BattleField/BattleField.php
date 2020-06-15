<?php

namespace Emagia\BattleField;

use Emagia\BattleField\Exception\BattleFieldDrawException;
use Emagia\BattleField\Exception\BattleFieldException;
use Emagia\BattleField\Exception\BattleFieldKOException;
use Emagia\Hero\HeroInterface;
use Emagia\Hero\Property\HeroPropertyType;
use Emagia\Hero\Skill\HeroSkillType;
use Psr\Log\LoggerInterface;

/**
 * Class BattleField
 * @package Emagia\BattleField
 */
class BattleField
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var HeroInterface
     */
    private $attacker;

    /**
     * @var HeroInterface
     */
    private $defender;

    /**
     * BattleField constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    private function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param HeroInterface $leftCornerHero
     * @param HeroInterface $rightCornerHero
     * @param int $rounds
     * @return HeroInterface
     */
    public function fight(HeroInterface $leftCornerHero, HeroInterface $rightCornerHero, int $rounds = 20): HeroInterface
    {
        /** @throws BattleFieldException */
        $this->attacker = $this->getFirstAttacker($leftCornerHero, $rightCornerHero);

        if ($this->attacker === $leftCornerHero) {
            $this->defender = $rightCornerHero;
        } else {
            $this->defender = $leftCornerHero;
        }

        $this->getLogger()->alert('First attacker is ' . $this->attacker->getName());

        $winner = $this->getLastHeroStanding($rounds);

        $this->getLogger()->notice('The winner is ' . $winner->getName());

        return $winner;
    }

    /**
     * @comment Defender becomes Attacker, and vice versa
     */
    private function switchRoles()
    {
        $tmp = $this->attacker;

        $this->attacker = $this->defender;
        $this->defender = $tmp;

        $this->getLogger()->alert($this->attacker->getName() . ' is preparing to attack ' . $this->defender->getName());

        unset($tmp);
    }

    /**
     * @param HeroInterface $hero
     */
    public function presentFighter(HeroInterface $hero)
    {
        $this->getLogger()->alert('Presenting ' . $hero->getName());

        $heroProperties = $hero->getProperties();

        if (!empty($heroProperties)) {
            $this->getLogger()->info($hero->getName() . ' properties:');

            foreach ($heroProperties as $heroProperty) {
                $this->getLogger()->info(' - ' . $heroProperty->getType() . ' = ' . $heroProperty->getValue());
            }
        }

        $heroSkills = $hero->getSkills();

        if (!empty($heroSkills)) {
            $this->getLogger()->info($hero->getName() . ' skills:');

            foreach ($heroSkills as $heroSkill) {
                $this->getLogger()->info(' - ' . $heroSkill->getType() . ' (' . $heroSkill->getChance() . '%)');
            }
        }
    }

    /**
     * @param HeroInterface $leftCornerHero
     * @param HeroInterface $rightCornerHero
     * @return HeroInterface
     * @throws BattleFieldException
     */
    public function getFirstAttacker(HeroInterface $leftCornerHero, HeroInterface $rightCornerHero): HeroInterface
    {
        /**
         * Apply spaceship operator
         */
        $speedSpaceShipOperatorResult = $leftCornerHero->getProperty(HeroPropertyType::SPEED)->getValue() <=> $rightCornerHero->getProperty(HeroPropertyType::SPEED)->getValue();

        /**
         * Rule #1: fighter with higher speed attacks first
         */
        if (-1 === $speedSpaceShipOperatorResult) {
            return $rightCornerHero;
        } else if (1 === $speedSpaceShipOperatorResult) {
            return $leftCornerHero;
        }

        /**
         * Rule #2: fighter with highest luck attacks first
         */
        $luckSpaceShipOperatorResult = $leftCornerHero->getProperty(HeroPropertyType::LUCK)->getValue() <=> $rightCornerHero->getProperty(HeroPropertyType::LUCK)->getValue();

        if (-1 === $luckSpaceShipOperatorResult) {
            return $rightCornerHero;
        } else if (1 === $luckSpaceShipOperatorResult) {
            return $leftCornerHero;
        }

        /**
         * Special case: the fighters have the same speed and luck
         */
        throw new BattleFieldException('Both fighters have the same speed and luck. Cannot figure out who should start first.');
    }

    /**
     * @param int $rounds
     * @return HeroInterface
     */
    private function getLastHeroStanding(int $rounds): HeroInterface
    {
        try {
            $roundCounter = 0;

            while ($roundCounter < $rounds) {
                $roundCounter++;

                $this->getLogger()->info('Starting round #' . $roundCounter);

                $this->attackerStrikesDefender();

                /**
                 * @comment Rapid strike: Strike twice while it’s his turn to attack
                 */
                $rapidStrikeSkill = $this->attacker->getSkill(HeroSkillType::RAPID_STRIKE);

                if (!empty($rapidStrikeSkill) && rand(0, 99) < $rapidStrikeSkill->getChance()) {
                    $this->getLogger()->notice('* ' . $this->attacker->getName() . ' uses skill ' . $rapidStrikeSkill->getType() . ' and strikes again.');
                    $this->attackerStrikesDefender();
                }

                $this->switchRoles();
            }

            return $this->getWinnerOnPoints();
        } catch (BattleFieldKOException $exception) {
            return $this->attacker;
        }
    }

    private function attackerStrikesDefender()
    {
        $remainingHealthBeforeAttack = $this->defender->getProperty(HeroPropertyType::HEALTH)->getValue();

        /**
         * The defender gets lucky
         *
         * @comment An attacker can miss their hit and do no damage if the defender gets lucky that turn.
         */
        if (rand(0, 99) < $this->defender->getProperty(HeroPropertyType::LUCK)->getValue()) {
            $damageValue = 0;
            $this->getLogger()->notice(
               '* ' . $this->defender->getName() . ' got lucky'
                . ', ' . $this->attacker->getName() . ' misses the attack'
            );
        } else {
            $damageValue = $this->attacker->getProperty(HeroPropertyType::STRENGTH)->getValue() - $this->defender->getProperty(HeroPropertyType::DEFENCE)->getValue();

            /**
             * @comment: Magic shield: Takes only half of the usual damage when an enemy attacks
             */
            $magicShieldSkill = $this->defender->getSkill(HeroSkillType::MAGIC_SHIELD);

            if (!empty($magicShieldSkill) && rand(0, 99) < $magicShieldSkill->getChance()) {
                $this->getLogger()->notice('* ' . $this->defender->getName() . ' uses skill ' . $magicShieldSkill->getType() . ' and takes only half of the usual damage.');
                $damageValue = (int)$damageValue / 2;
            }
        }

        $this->defender->createDamage($damageValue);

        $remainingHealth = $this->defender->getProperty(HeroPropertyType::HEALTH)->getValue();

        $this->getLogger()->info(
            $this->attacker->getName() . ' creates a damage of ' . $damageValue . ' to ' . $this->defender->getName() .
            ' (Health goes from ' . $remainingHealthBeforeAttack . ' to '. $remainingHealth. ')'
        );

        if ($remainingHealth <= 0) {
            $this->getLogger()->alert($this->defender->getName() . ' was K.O. Game over.');
            throw new BattleFieldKOException($this->defender->getName() . ' was K.O. Game over.');
        }
    }

    /**
     * @return HeroInterface
     * @throws BattleFieldDrawException
     */
    private function getWinnerOnPoints(): HeroInterface
    {
        $healthSpaceShipOperatorResult = $this->attacker->getProperty(HeroPropertyType::HEALTH)->getValue() <=> $this->defender->getProperty(HeroPropertyType::HEALTH)->getValue();

        /**
         * Rule #1: Fighter with greater health wins
         */
        if (-1 === $healthSpaceShipOperatorResult) {
            return $this->defender;
        } else if (1 === $healthSpaceShipOperatorResult) {
            return $this->attacker;
        }

        /**
         * Rule #2: Fighter with greater luck wins
         */
        $luckSpaceShipOperatorResult = $this->attacker->getProperty(HeroPropertyType::LUCK)->getValue() <=> $this->defender->getProperty(HeroPropertyType::LUCK)->getValue();

        if (-1 === $luckSpaceShipOperatorResult) {
            return $this->defender;
        } else if (1 === $luckSpaceShipOperatorResult) {
            return $this->attacker;
        }

        /**
         * Special case: the fighters have the same health and luck
         */
        throw new BattleFieldDrawException('Both fighters have the same health left and luck. Draw!');
    }
}
