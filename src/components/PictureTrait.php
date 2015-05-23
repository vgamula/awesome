<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\components;

use Yii;

/**
 * Trait PictureTrait
 *
 * @property string $picture
 */
trait PictureTrait
{
    /**
     * @return string
     */
    public function getPicture()
    {
        if (!empty($this->image) && file_exists(Yii::getAlias('@webroot') . urldecode($this->image))) {
            return $this->image;
        }
        return '/img/no-image.jpg';
    }

} 