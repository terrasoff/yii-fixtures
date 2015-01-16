<?php

namespace terrasoff\yii\fixtures;

use CConsoleCommand;
use Exception;
use Yii;

/**
 * Class ConsoleFixtureCommand
 * @package Infotech\Autocrm\Common
 */
class ConsoleFixtureManager extends CConsoleCommand
{
    private $_references = [];

    public $fixtures = [];
    const CONFIG_SET = 'set';

    /**
     * @param string $set определенная фикстура (полный путь)
     * @param bool $flush очищаем таблицу?
     */
    public function actionLoad($set, $flush = true)
    {
        $this->load($set, $flush);
    }

    /**
     * @param string $set определенная фикстура (полный путь)
     * @param bool $flush очищаем таблицу?
     */
    protected function load($set, $flush = true)
    {
        if (!isset($this->fixtures[$set])) {
            throw new Exception(printf("Набор фикстур %s не найден", $set));
        }

        foreach ($this->fixtures[$set] as $name => $fixtureClass) {
            // текущая фикстура - поднабор
            if (is_string($name) && $name === self::CONFIG_SET) {
                $this->load($name, $flush);
            } else {
                /** @var Fixture $fixture */
                $fixture = new $fixtureClass;
                $fixture->process($flush);
            }
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
