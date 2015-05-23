<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Event]].
 *
 * @see Event
 */
class EventsQuery extends ActiveQuery
{
    public function top()
    {
        $this->limit(5);
        $this->andWhere(['>=', 'start', date('Y-m-d H:i:s')]);
        return $this;
    }

    public function filterByUser()
    {
        if (\Yii::$app->user->isGuest) {
            $this->andWhere(['visible' => Event::VISIBLE_PUBLIC]);
        }else{
            //$this->andWhere([]);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}