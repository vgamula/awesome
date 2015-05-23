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
        $this->andWhere(['>=', 'start', date('Y-m-d H:i:s')]);
        return $this;
    }

    public function enable()
    {
        $this->andWhere(['status' => Event::STATUS_ENABLE]);
        return $this;
    }

    public function byTitle($title)
    {
        $title = trim($title);
        $words = explode(' ', $title);
        foreach ($words as $word) {
            $this->orFilterWhere(['like', 'name', $word]);
            $this->orFilterWhere(['like', 'placeName', $word]);
        }
        return $this;
    }

    public function filterByUser()
    {
        if (\Yii::$app->user->isGuest) {
            $this->andWhere(['visible' => Event::VISIBLE_PUBLIC]);
        } else {
            //$this->andWhere([]);@TODO
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