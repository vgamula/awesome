<?php

namespace app\models;

use nullref\useful\JsonBehavior;
use voskobovich\behaviors\ManyToManyBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
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
 * @property string|array $photos
 * @property integer $visible
 * @property integer $status
 *
 * @property string $from
 * @property string $to
 * @property User[] $users
 * @property User[] $usersList
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

    public function init()
    {
        $this->photos = [];
        parent::init();
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
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'usersList' => 'users',
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'userId',
                'updatedByAttribute' => 'userId',
            ],
            [
                'class' => JsonBehavior::className(),
                'fields' => ['photos'],
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
            [['lat'], 'default', 'value' => 30.545581470360048],
            [['lng'], 'default', 'value' => 50.43576711617286],
            [['description'], 'string'],
            [['start'], 'compareDates'],
            [['lat', 'lng'], 'number'],
            [['usersList', 'userId', 'photos'], 'safe'],
            [['start', 'end', 'name', 'description', 'placeName'], 'required'],
            [['visible', 'status'], 'integer'],
            [['name', 'placeName'], 'string', 'max' => 255]
        ];
    }

    public function compareDates()
    {
        if (!$this->hasErrors()) {
            if (strtotime($this->start) >= strtotime($this->end)) {
                $this->addError('start', Yii::t('app', 'Start time must be less than end time'));
            }
        }
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
    public function getUsers()
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

    /**
     * Check user as subscriber
     * @param User $user
     * @return boolean
     */
    public function hasSubscriber(User $user)
    {
        return UserHasEvents::find()->where(['userId' => $user->id, 'eventId' => $this->id])->exists();
    }
}
