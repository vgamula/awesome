<?php

namespace app\controllers;

use app\models\catalog\Category;
use app\models\catalog\Product;
use app\models\catalog\Vendor;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;

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
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => ['pageSize' => 4]
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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

    /**
     * View product
     * @param $id
     * @return string
     */
    public function actionProduct($id)
    {
        return $this->render('product', ['model' => $this->findProduct($id)]);
    }

    /**
     * View vendor products
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionVendor($id)
    {
        if (($model = Vendor::findOne($id)) === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->enabled()->byVendor($id),
        ]);
        return $this->render('vendor', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View category products
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        /** @var Category $model */
        if (($model = Category::findOne($id)) === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getProducts()->enabled(),
        ]);
        return $this->render('category', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionProducts()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->enabled(),
        ]);
        return $this->render('products', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProduct($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
