<?php

use DI\ContainerBuilder;
use Emagia\BattleField\BattleField;
use Emagia\BattleField\Exception\BattleFieldDrawException;
use Emagia\BattleField\Exception\BattleFieldException;
use Emagia\Hero\Beast;
use Emagia\Hero\Exception\HeroException;
use Emagia\Hero\Exception\HeroSkillException;
use Emagia\Hero\Exception\HeroValidationException;
use Emagia\Hero\HeroFactory;
use Emagia\Hero\HeroType;
use Emagia\Hero\Orderus;
use Emagia\Hero\Property\HeroProperty;
use Emagia\Hero\Skill\HeroSkill;
use Emagia\Hero\Skill\HeroSkillType;
use Emagia\Hero\Validator\HeroValidator;

require_once 'vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(require_once 'config/definitions.php');
$container = $builder->build();

/**
 * Step 1: Build the first hero - Orderus
 */
try {
    $orderusProperties = [];

    foreach (Orderus::buildPropertiesConstraints() as $propertyConstraint) {
        $orderusProperties[] = new HeroProperty(
            $propertyConstraint->getType(),
            rand($propertyConstraint->getMinValue(), $propertyConstraint->getMaxValue())
        );
    }

    $orderusSkills = [];
    $orderusSkills[] = new HeroSkill(HeroSkillType::RAPID_STRIKE, 10);
    $orderusSkills[] = new HeroSkill(HeroSkillType::MAGIC_SHIELD, 20);

    /** @var Orderus $orderus */
    $orderus = HeroFactory::make('Orderus', HeroType::ORDERUS, $orderusProperties, $orderusSkills);

    (new HeroValidator())->validateHero($orderus);
} catch (HeroValidationException $exception) {
    die('HeroValidationException caught: ' . $exception->getMessage());
} catch (HeroSkillException $exception) {
    die('HeroSkillException caught: ' . $exception->getMessage());
} catch (HeroException $exception) {
    die('HeroException caught: ' . $exception->getMessage());
}

/**
 * Step 2: Build the second hero - Red Wild Beast
 */
try {
    $beastProperties = [];

    foreach (Beast::buildPropertiesConstraints() as $propertyConstraint) {
        $beastProperties[] = new HeroProperty(
            $propertyConstraint->getType(),
            rand($propertyConstraint->getMinValue(), $propertyConstraint->getMaxValue())
        );
    }

    $beast = HeroFactory::make('Red Wild Beast', HeroType::BEAST, $beastProperties, []);

    (new HeroValidator())->validateHero($beast);
} catch (HeroValidationException $exception) {
    die('HeroValidationException caught: ' . $exception->getMessage());
} catch (HeroSkillException $exception) {
    die('HeroSkillException caught: ' . $exception->getMessage());
} catch (HeroException $exception) {
    die('HeroException caught: ' . $exception->getMessage());
}

/**
 * Step 3: Let the hero fight and get the winner
 */
try {
    /** @var BattleField $battleField */
    $battleField = $container->get('battlefield');

    /** Present heroes before fight */
    $battleField->presentFighter($orderus);
    $battleField->presentFighter($beast);

    $winner = $battleField->fight($orderus, $beast, 20);
} catch (BattleFieldDrawException $exception) {
    die('BattleFieldDrawException caught: ' . $exception->getMessage());
} catch (BattleFieldException $exception) {
    die('BattleFieldException caught: ' . $exception->getMessage());
}
