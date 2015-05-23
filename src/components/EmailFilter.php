<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 AtNiwe
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace app\components;


use yii\base\ActionFilter;

class EmailFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest) {
            return true;
        }
        if ($action->id != 'set-email') {
            if (empty(\Yii::$app->user->identity->email)) {
                \Yii::$app->getResponse()->redirect(['/site/set-email']);
                return false;
            }
        }
        return true;

    }

} 