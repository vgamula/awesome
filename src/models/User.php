<?php

namespace app\models;

use voskobovich\behaviors\ManyToManyBehavior;
use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $facebookId
 * @property string $twitterId
 * @property string $googleId
 * @property string $avatar
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $email
 *
 * @property Event[] $events
 * @property Event[] $eventsList
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',], 'required'],
            [['eventsList'], 'safe'],
            [['createdAt', 'updatedAt'], 'integer'],
            [['facebookId', 'twitterId', 'googleId', 'avatar'], 'safe',],
            [['email'], 'email'],
        ];
    }

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
                    'eventsList' => 'events',
                ],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Name'),
            'facebookId' => Yii::t('app', 'Facebook ID'),
            'twitterId' => Yii::t('app', 'Twitter ID'),
            'googleId' => Yii::t('app', 'Google ID'),
            'avatar' => Yii::t('app', 'Avatar'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @inheritdoc
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @var array EAuth attributes
     */
    public $profile;

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findByUsername($username)
    {
        throw new NotSupportedException();
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service, $serviceName)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $serviceId = $service->getId();
        $fieldName = $serviceName . 'Id';
        $user = self::findOne([$fieldName => $serviceId]);
        if (!isset($user)) {
            $attributes = $service->getAttributes();
            $user = new self([
                'username' => $attributes['name'],
                $fieldName => $serviceId,
            ]);
            $user->save(false);
        }
        return $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    public function validatePassword()
    {
        throw new NotSupportedException();
    }

    /**
     * Finds an identity by the given secrete token.
     *
     * @param string $token the secrete token
     * @param null $type type of $token
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['id' => 'eventId'])
            ->viaTable('{{%user_has_events}}', ['userId' => 'id']);
    }

    public function loadAvatar()
    {
        if (!$this->email) {
            return;
        }
        $defaultAvatar = Yii::$app->params['defaultAvatar'];
        $size = Yii::$app->params['avatarSize'];
        $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?d=" . urlencode($defaultAvatar) . "&s=" . $size;

        $this->avatar = $grav_url;
    }

    public function beforeSave($insert)
    {
        $this->loadAvatar();
        return parent::beforeSave($insert);
    }

}
