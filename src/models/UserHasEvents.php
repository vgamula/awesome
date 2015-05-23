<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_has_events}}".
 *
 * @property integer $userId
 * @property integer $eventId
 */
class UserHasEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_has_events}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'eventId'], 'required'],
            [['userId', 'eventId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => Yii::t('app', 'User ID'),
            'eventId' => Yii::t('app', 'Event ID'),
        ];
    }
}
