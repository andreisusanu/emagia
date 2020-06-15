<?php

use Emagia\BattleField\BattleField;
use GAubry\Logger\ColoredIndentedLogger;
use Interop\Container\ContainerInterface;

/**
 * Dependency injector definitions
 */
$definitions = [];

/**
 * @return ColoredIndentedLogger
 */
$definitions['logger'] = function(): ColoredIndentedLogger {
    $config = [
        'colors' => [
            'debug' => "",
            'alert' => "\e[92m",
            'error' => "",
            'info' => "\e[96m",
            'critical' => "",
            'emergency' => "",
            'notice' => "\e[91m",
            'warning' => "",
            'log' => "",
        ]
    ];

    return new ColoredIndentedLogger($config);
};

/**
 * @param ContainerInterface $container
 * @return BattleField
 */
$definitions['battlefield'] = function(ContainerInterface $container): BattleField {
    return new BattleField($container->get('logger'));
};

return $definitions;
