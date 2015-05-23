<?php
/**
 *
 */


namespace app\components;

use unclead\widgets\MultipleInput as BaseInput;
use Yii;
use yii\base\InvalidConfigException;

class MultipleInput extends BaseInput
{
    /**
     * @var string Class to use for columns
     */
    public $columnClass = 'unclead\widgets\MultipleInputColumn';

    /**
     * Initialization.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->columnClass)) {
            throw new InvalidConfigException(get_called_class() . '::$columnClass must be set');
        }
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->guessColumns();
        }
        foreach ($this->columns as $i => $column) {
            $column = Yii::createObject(array_merge([
                'class' => $this->columnClass,
                'widget' => $this,
            ], $column));
            $this->columns[$i] = $column;
        }
    }
} 