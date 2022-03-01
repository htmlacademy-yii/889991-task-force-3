<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth".
 *
 * @property int $id
 * @property int $iser_id
 * @property string $source
 * @property string $sourse_id
 *
 * @property Users $iser
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iser_id', 'source', 'sourse_id'], 'required'],
            [['iser_id', 'sourse_id'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['iser_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['iser_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iser_id' => 'Iser ID',
            'source' => 'Source',
            'sourse_id' => 'Sourse ID',
        ];
    }

    /**
     * Gets query for [[Iser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIser()
    {
        return $this->hasOne(User::className(), ['id' => 'iser_id']);
    }
}
