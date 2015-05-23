<?php

namespace app\components;

use app\models\catalog\Product;
use Yii;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Helper
{
    public static function getStatuses()
    {
        return [
            Product::STATUS_DISABLE => Yii::t('catalog', 'Disable'),
            Product::STATUS_ENABLE => Yii::t('catalog', 'Enable'),
        ];
    }

    public static function getInputFileOptions($options = [])
    {
        $defaults = [

            'buttonName' => Yii::t('app', 'Browse'),
            'language' => 'ru',
            'controller' => 'elfinder',
            'filter' => 'image',
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'options' => ['class' => 'form-control'],
            'buttonOptions' => ['class' => 'btn btn-default'],
            'multiple' => false
        ];

        return array_merge($options, $defaults);
    }
}