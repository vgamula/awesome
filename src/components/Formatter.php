<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\components;

use app\models\catalog\Category;
use app\models\catalog\Vendor;
use app\models\orders\Order;
use Yii;
use yii\helpers\Html;


class Formatter extends \yii\i18n\Formatter
{
    public function asStatus($value)
    {
        return isset(Helper::getStatuses()[$value]) ? Helper::getStatuses()[$value] : Yii::t('app', 'N/A');
    }

    public function asFancyImage($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        return Html::a(Html::img($value,['class' => 'img-thumbnail']), $value, ['rel' => 'fancybox']);
    }

    public function asMoney($value, $decimals = null, $options = [], $textOptions = [])
    {
        return parent::asDecimal($value, $decimals, $options, $textOptions) . ' ' . Yii::t('app', 'UAH');
    }

    public function asReadMore($value, $config = null)
    {
        return $this->asHtml(Html::tag('div', $value, ['class' => 'read-more']), $config);
    }
} 