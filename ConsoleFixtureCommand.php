<?php

namespace terrasoff\yii\fixtures;

use CConsoleCommand;
use Yii;

/**
 * Class ConsoleFixtureCommand
 * @package Infotech\Autocrm\Common
 */
class ConsoleFixtureCommand extends CConsoleCommand
{
    public $fixtures = [
        'users',
    ];

    /**
     * @param array $args
     */
    public function run($arg = [])
    {
        foreach ($this->fixtures as $fixtureName) {
            if (method_exists($this, $fixtureName)) {
                $this->{$fixtureName}();
            }
        }
    }
}
