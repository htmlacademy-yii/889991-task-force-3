<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\Category;
use app\models\City;
use yii\web\Controller;

class TasksController extends Controller 
{
   public function actionIndex()
   {
      $tasks = Task::find()
      ->where(['task_status' => 'new'])
      ->joinWith(['category', 'city'])
      ->orderBy(['date_creation' => SORT_DESC])
      ->all();

      return $this->render('index', ['tasks' => $tasks]);
   }
}