<?php

namespace terrasoff\yii\fixtures;

use CActiveRecord;

abstract class Fixture
{
    /**
     * @var ConsoleFixtureManager
     */
    private $_manager = null;

    private $_models = [];

    private function getManager()
    {
        return $this->_manager;
    }

    public function setReference($alias, $object)
    {
        $this->getManager()->setReference($alias, $object);
    }

    public function process()
    {
        /** @var CActiveRecord $model */
        foreach ($this->_models as $model) {
            $model->save();
        }

        return true;
    }
}
