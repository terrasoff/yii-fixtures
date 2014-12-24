<?php

namespace terrasoff\yii\fixtures;

use CConsoleCommand;
use Yii;

/**
 * Class ConsoleFixtureCommand
 * @package Infotech\Autocrm\Common
 */
class ConsoleFixtureManager extends CConsoleCommand
{
    private $_references = [];

    public $fixtures = [];

    /**
     * @param array $args
     */
    public function run($arg = [])
    {
        foreach ($this->fixtures as $fixtureClass) {
            /** @var Fixture $fixture */
            $fixture = new $fixtureClass;
            $fixture->process();
        }
    }

    public function setReference($alias, $object)
    {
        $this->_references[$alias] = $object;
    }

    public function getReference($alias)
    {
        return $this->_references[$alias];
    }
}
