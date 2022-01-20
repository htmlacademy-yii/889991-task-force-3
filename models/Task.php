<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $date_creation
 * @property string|null $title
 * @property string|null $task_description
 * @property int|null $budget
 * @property string|null $period_execution
 * @property int|null $city_id
 * @property string|null $task_location
 * @property int|null $user_id
 * @property int|null $executor_id
 * @property int|null $category_id
 * @property string|null $task_status
 *
 * @property Categories $category
 * @property Cities $city
 * @property Files[] $files
 * @property Response[] $responses
 * @property Reviews[] $reviews
 * @property Users $user
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_creation', 'period_execution'], 'safe'],
            [['task_description'], 'string'],
            [['budget', 'city_id', 'user_id', 'executor_id', 'category_id'], 'integer'],
            [['title', 'task_location'], 'string', 'max' => 255],
            [['task_status'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_creation' => 'Date Creation',
            'title' => 'Title',
            'task_description' => 'Task Description',
            'budget' => 'Budget',
            'period_execution' => 'Period Execution',
            'city_id' => 'City ID',
            'task_location' => 'Task Location',
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'category_id' => 'Category ID',
            'task_status' => 'Task Status',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
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
