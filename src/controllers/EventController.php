<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Event;
use app\models\EventSearch;
use app\models\User;
use app\models\UserHasEvents;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends BaseController
{
    public function behaviors()
    {
        return  ArrayHelper::merge(parent::behaviors(),[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'index', 'subscribe', 'unsubscribe'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'index', 'subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $googleId = Yii::$app->params['googleId'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'googleId' => $googleId
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model->userIsOwner()) {
            throw new ForbiddenHttpException();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->userIsOwner()) {
            throw new ForbiddenHttpException();
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionExport()
    {
        return $this->render('export');
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Subscribe current user to event by id
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSubscribe($id)
    {
        /** @var Event $event */
        $event = Event::findOne($id);
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!isset($event) || UserHasEvents::find(['eventId' => $event->id, 'userId' => $user->id])->exists()) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        $relation = new UserHasEvents(['eventId' => $event->id, 'userId' => $user->id]);
        $relation->save(false);

        return $this->redirect(['view', 'id' => $event->id]);
    }

    /**
     * Unsubscribe current user from event by id
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUnsubscribe($id)
    {
        /** @var Event $event */
        $event = Event::findOne($id);
        /** @var User $user */
        $user = Yii::$app->user->identity;
        /** @var UserHasEvents $relation */
        $relation = UserHasEvents::findOne(['eventId' => $event->id, 'userId' => $user->id]);
        if (!isset($event) || !isset($relation)) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        $relation->delete();

        return $this->redirect(['view', 'id' => $event->id]);
    }
}
