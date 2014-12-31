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

    public function addModel(CActiveRecord $model)
    {
        $this->_models[] = $model;
    }

    /**
     * Очищаем таблицу?
     * @param bool $flush
     * @return bool
     */
    public function process($flush = true)
    {
        if (count($this->_models) > 0 && $flush) {
            /** @var CActiveRecord $model */
            $model = $this->_models[0];
            $model->deleteAll();
        }

        /** @var CActiveRecord $model */
        foreach ($this->_models as $model) {
            $model->save();
        }

        return true;
    }
}
