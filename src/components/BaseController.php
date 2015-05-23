<?php
/**
 * @author    Dmytro Karpovych
 */

namespace app\components;


use yii\web\Controller;


class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'emailCheck' => [
                'class' => EmailFilter::className(),
            ],
        ];
    }


} 