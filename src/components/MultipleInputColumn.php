<?php
/**
 *
 */

namespace app\components;

use unclead\widgets\MultipleInputColumn as BaseInputColumn;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class MultipleInputColumn extends BaseInputColumn
{
    const TYPE_WIDGET = 'widget';

    /**
     * @var array configuration for custom widget
     */
    public $widgetConfig = [];

    public function init()
    {
        parent::init();
        if ($this->type == static::TYPE_WIDGET && empty($this->widgetConfig['class'])) {
            throw new InvalidConfigException(get_called_class() . '::widgetConfig[\'class\'] must set to use widget type.');
        }
    }

    /**
     * Renders the cell content.
     *
     * @param string $value placeholder of the input's value
     * @return string
     * @throws InvalidConfigException
     */
    public function renderCellContent($value)
    {
        $type = $this->type;
        $name = $this->widget->getElementName($this->name);

        $options = $this->options;
        $options['id'] = $this->widget->getElementId($this->name);
        Html::addCssClass($options, 'form-control');

        switch ($this->type) {
            case static::TYPE_HIDDEN_INPUT:
                $input = Html::hiddenInput($name, $value, $options);
                break;
            case static::TYPE_DROPDOWN:
            case static::TYPE_LISTBOX:
            case static::TYPE_CHECKBOX_LIST:
            case static::TYPE_RADIO_LIST:
                $options['selectedOption'] = $value;
                $input = Html::$type($name, null, $this->items, $options);
                break;
            case static::TYPE_STATIC:
                $input = $value;
                break;
            case static::TYPE_WIDGET:
                /** @var \yii\base\Widget $class */
                $class = $this->widgetConfig['class'];
                unset($this->widgetConfig['class']);
                $this->widgetConfig['name'] = $name;
                $input = $class::widget($this->widgetConfig);
                break;
            default:
                if (method_exists('yii\helpers\Html', $type)) {
                    $input = Html::$type($name, $value, $options);
                } else {
                    throw new InvalidConfigException("Invalid column type '$type'");
                }
        }

        if ($this->isHiddenInput()) {
            return $input;
        }

        $input = Html::tag('div', $input, [
            'class' => 'form-group field-' . $options['id'],
        ]);
        return Html::tag('td', $input, [
            'class' => 'list-cell__' . $this->name,
        ]);
    }
} 