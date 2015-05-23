<?php
namespace app\commands;

use app\models\Event;
use yii\console\Controller;

/**
 *
 */
class ScheduleController extends Controller
{

    public $defaultAction = 'index';

    public function actionIndex()
    {

        $date = new \DateTime();
        $date->add(new \DateInterval('P' . \Yii::$app->params['remindeBefore'] . 'D'));
        $date2 = new \DateTime();
        $date2->add(new \DateInterval('P' . \Yii::$app->params['remindeBefore'] . 'D'));
        $events = Event::find()
            ->andWhere(['>=', 'start', $date->format("Y-m-d H:i:s")])
            ->andWhere(['>=', 'start', $date2->format("Y-m-d H:i:s")])
            ->joinWith(['users'])
            ->all();


        foreach ($events as $event) {
            foreach ($event->users as $user) {
                if ($user->email) {
                    \Yii::$app->mailer->compose('notification', ['event' => $event, 'user' => $user])
                        ->setTo($user->email)
                        ->setFrom(\Yii::$app->params['adminEmail'])
                        ->send();
                    echo 'Send ' . $event->getTitle() . ' to ' . $user->email . PHP_EOL;
                }
            }

        }
    }
}
