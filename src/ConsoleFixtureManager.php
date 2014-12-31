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
     * @param bool $flush очищаем таблицу?
     * @param string $fixture определенная фикстура (полный путь)
     */
    public function actionLoad($flush = true, $fixture = null)
    {
        $list = $fixture !== null
            ? [$fixture]
            : $this->fixtures;

        foreach ($list as $fixtureClass) {
            /** @var Fixture $fixture */
            $fixture = new $fixtureClass;
            $fixture->process($flush);
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
