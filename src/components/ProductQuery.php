<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\components;

use app\models\catalog\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function enabled()
    {
        return $this->andWhere(['status' => Product::STATUS_ENABLE]);
    }

    public function byVendor($id)
    {
        return $this->andWhere(['vendorId' => $id]);
    }
}