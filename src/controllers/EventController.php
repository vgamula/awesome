<?php

namespace app\controllers;

use app\models\User;
use app\models\UserHasEvents;
use Yii;
use app\models\Event;
use app\models\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
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
        return $this->render('view', [
            'model' => $this->findModel($id),
            'gooogleId' => '723383549848-a2988ciq9d1jsie29v79seui32trsbko.apps.googleusercontent.com'
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
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
