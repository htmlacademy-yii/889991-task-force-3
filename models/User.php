<?php

namespace app\models;

use Yii;
use app\models\City;
/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $date_registration
 * @property string|null $user_name
 * @property string $email
 * @property int|null $city_id
 * @property string|null $user_password
 * @property int|null $role_id
 *
 * @property Cities $city
 * @property Executors[] $executors
 * @property Reviews[] $reviews
 * @property Roles $role
 * @property Tasks[] $tasks
 */
class User extends \yii\db\ActiveRecord
{
   public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_registration', 'role_id'], 'safe'],
            [['user_name', 'email', 'city_id', 'user_password', 'password_repeat'], 'required'],
            [['user_name', 'email'], 'string', 'length' => [2, 128]],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class],
            [['user_password'], 'string', 'length' => [6, 128]],
            [['password_repeat'], 'compare', 'compareAttribute' => 'user_password'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_registration' => 'Date Registration',
            'user_name' => 'Ваше имя',
            'email' => 'Email',
            'city_id' => 'Город',
            'user_password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'role_id' => 'я собираюсь откликаться на заказы',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasMany(Executor::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasMany(Review::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
    }
}
