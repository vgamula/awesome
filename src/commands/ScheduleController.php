<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Event;
use app\models\EventSearch;
use app\models\User;

/**
 *
 */
class ScheduleController extends Controller {

    public $defaultAction = 'index';

    public function actionIndex()
    {

      $date = new \DateTime();
      // $date->add(new \DateInterval('P10D'));
      //var_dump($date);
      $events = Event::find()
       ->where(['>=', 'start', $date->format("Y-m-d H:i:s")])
       ->joinWith(['users'])
       ->all();



      foreach ($events as $event) {
        // echo $event->email;
        var_dump($event);
      }
      // var_dump($events);
    }
}
