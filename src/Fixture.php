<?php

namespace terrasoff\yii\fixtures;

class Fixture
{
    public function run($arg = [])
    {
        foreach ($this->fixtures as $fixtureName) {
            if (method_exists($this, $fixtureName)) {
                $this->{$fixtureName}();
            }
        }
    }
}
