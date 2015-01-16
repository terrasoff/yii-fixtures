<?php

namespace terrasoff\yii\fixtures;

use CActiveRecord;
use Closure;
use Exception;

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

    /**
     * @param CActiveRecord|array $model
     */
    public function addModel($model)
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

            is_array($model)
                ? $model['model']->deleteAll()
                : $model->deleteAll();
        }

        foreach ($this->_models as $model) {
            if (is_array($model)) {
                if (!isset($model['model'])) {
                    throw new Exception(
                        'При сохранении элемента фикстуры не сконфигурирована модель.'.
                        'Конфигурация модели задается ключом "model"'
                    );
                }

                if ($model['model']->save()) {
                    if (isset($model['afterSave']) && $model['afterSave'] instanceof Closure) {
                        call_user_func_array($model['afterSave'], [
                            $model['model']
                        ]);
                    }
                }
            } else {
                /** @var CActiveRecord $model */
                $model->save();
            }
        }

        return true;
    }
}
