<?php

namespace app\models;

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
            [['createdAt', 'updatedAt'], 'integer'],
            [['facebookId', 'twitterId', 'googleId', 'avatar'], 'safe',]
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
    public static function findByEAuth($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $serviceName = $service->getServiceName();
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
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
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
}
