<?php

namespace app\controllers;

use app\models\catalog\Category;
use app\models\catalog\Product;
use app\models\catalog\Vendor;
use app\models\ContactForm;
use app\models\Event;
use app\models\User;
use nodge\eauth\ErrorException;
use nodge\eauth\openid\ControllerBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'eauth' => array(
                // required to disable csrf validation on OpenID requests
                'class' => ControllerBehavior::className(),
                'only' => array('login'),
            ),
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Event::find()->top(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin()
    {
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));
            try {
                if ($eauth->authenticate()) {
                    $identity = User::findByEAuth($eauth);

                    Yii::$app->getUser()->login($identity);
                    if (!Yii::$app->user->isGuest) {
                        $eauth->redirect();
                    }
                } else {
                    $eauth->cancel();
                }
            } catch (ErrorException $e) {
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
        return $this->render('login');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', Yii::$app->settings->get('site.contacts-success'));

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
