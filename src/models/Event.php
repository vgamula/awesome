<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property double $lat
 * @property double $lng
 * @property string $placeName
 * @property integer $visible
 * @property integer $status
 */
class Event extends ActiveRecord
{
    /** Visible types */
    const VISIBLE_PUBLIC = 1;
    const VISIBLE_PROTECTED = 2;
    const VISIBLE_PRIVATE = 3;

    /** Statuses */
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['lat', 'lng'], 'number'],
            [['visible', 'status'], 'integer'],
            [['name', 'placeName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'placeName' => Yii::t('app', 'Place Name'),
            'visible' => Yii::t('app', 'Visible'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return EventsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventsQuery(get_called_class());
    }
}
