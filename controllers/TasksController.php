<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\Category;
use app\models\TaskSearchForm;
use app\models\City;
use app\models\Response;
use yii\web\Controller;
use app\controllers\AppController;
use yii\db\Expression;

class TasksController extends Controller 
{
   public function actionIndex()
   {
      $model = new TaskSearchForm();
      if (Yii::$app->request->getIsPost()) {
         $model->load(Yii::$app->request->post());
      } 
      
      $query = Task::find()
      ->where(['task_status' => 'new'])
      ->joinWith(['category', 'city'])
      ->andWhere(['category_id' => $model->categories]);
      
      if ($model->no_location == 1) {
         $query->andWhere(['city_id' => null]);
      }
      if ($model->no_response == 1) {
         $query->andWhere(['position' => null]);
      }

      settype($model->period, 'integer');
        if ($model->period > 0) {
            $exp = new Expression("DATE_SUB(NOW(), INTERVAL {$model->period} HOUR)");
            $query->andWhere(['>', 'date_creation', $exp]);
        }
      $query->orderBy(['date_creation' => SORT_DESC]);
      $tasks = $query->all();
      
      $response = Response::find()->all();

      $categories = Category::find()->all();

      return $this->render('index', [
         'tasks' => $tasks, 
         'model' => $model,
         'categories' => $categories, 
         'period_values' => TaskSearchForm::PERIOD_VALUES]);
   }
}