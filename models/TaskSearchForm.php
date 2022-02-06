<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Category;

class TaskSearchForm extends Model {

   public $categories;
   public $no_location;
   public $no_response;
   public $period;

   const PERIOD_VALUES = [
      '0' => 'Без ограничений',
      '1' => '1 час',
      '12'  => '12 часов',
      '24' => '24 часа'
   ];
   public function attributeLabels()
   {
      return [
         'no_location' => 'Удаленная работа',
         'remoteWork' => 'Без откликов',
         'period' => 'Период',
      ];
   }


   

   public function rules()
    {
        return [
            [['categories', 'no_location', 'no_response', 'period'], 'safe']
        ];
    }




}