<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $start
 * @property integer $end
 * @property double $lat
 * @property double $lng
 * @property string $placeName
 * @property integer $visible
 * @property integer $status
 *
 * @property string $from
 * @property string $to
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

    public function getTitle()
    {
        return $this->name . " ($this->placeName)";
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ]);
    }

    /**
     * @return array
     */
    public static function getVisibilities()
    {
        return [
            self::VISIBLE_PUBLIC => Yii::t('app', 'Public'),
            self::VISIBLE_PROTECTED => Yii::t('app', 'Protected'),
            self::VISIBLE_PRIVATE => Yii::t('app', 'Private'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ENABLE => Yii::t('app', 'Enable'),
            self::STATUS_DISABLE => Yii::t('app', 'Disable'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['lat', 'lng'], 'number'],
            [['start', 'end', 'name', 'description'], 'required'],
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
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])
            ->viaTable('{{%user_has_events}}', ['eventId' => 'id']);
    }

    public function getJsonData()
    {
        return Json::encode([
                'title' => $this->getTitle(),
                'from' => $this->from,
                'to' => $this->to,
            ]
        );
    }

    public function getFrom()
    {
        return date(DATE_ISO8601, strtotime($this->start));
    }

    public function getTo()
    {
        return date(DATE_ISO8601, strtotime($this->end));
    }
}
