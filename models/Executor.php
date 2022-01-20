<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "executors".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $avatar
 * @property string|null $birthday
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $profile_info
 * @property string|null $current_status
 * @property int|null $count_compleded_tasks
 * @property int|null $count_failed_tasks
 * @property int|null $sum_ratings
 * @property string|null $specializations
 *
 * @property Response[] $responses
 * @property Reviews[] $reviews
 * @property Users $user
 */
class Executor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'count_compleded_tasks', 'count_failed_tasks', 'sum_ratings'], 'integer'],
            [['birthday'], 'safe'],
            [['profile_info'], 'string'],
            [['avatar', 'specializations'], 'string', 'max' => 255],
            [['phone', 'telegram', 'current_status'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'avatar' => 'Avatar',
            'birthday' => 'Birthday',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'profile_info' => 'Profile Info',
            'current_status' => 'Current Status',
            'count_compleded_tasks' => 'Count Compleded Tasks',
            'count_failed_tasks' => 'Count Failed Tasks',
            'sum_ratings' => 'Sum Ratings',
            'specializations' => 'Specializations',
        ];
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
