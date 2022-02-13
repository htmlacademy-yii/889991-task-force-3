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
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController 
{
   public function actionIndex()
   {
      $model = new TaskSearchForm();
      
      
      $query = Task::find()
      ->joinWith(['category', 'city'])
      ->where(['task_status' => 'new']);
      if (Yii::$app->request->getIsPost()) {
         $model->load(Yii::$app->request->post());

         $query->andWhere(['category_id' => $model->categories]);
     
         if ($model->no_location == 1) {
            $query->andWhere(['city_id' => null]);
         }
         if ($model->no_response == 1) {
            $query->andWhere(['position' => null]);
         }
      } else {
         $model->categories = [];
      }
      settype($model->period, 'integer');
        if ($model->period > 0) {
            $exp = new Expression("DATE_SUB(NOW(), INTERVAL {$model->period} HOUR)");
            $query->andWhere(['>', 'date_creation', $exp]);
        }
      $query->orderBy(['date_creation' => SORT_DESC]);
      $tasks = $query->all();
      //echo AppController::debug($tasks);

      $response = Response::find()->all();


      $categories = Category::find()->all();

      return $this->render('index', [
         'tasks' => $tasks, 
         'model' => $model,
         'categories' => $categories, 
         'period_values' => TaskSearchForm::PERIOD_VALUES
      ]);
   }

   public function actionView ($id) 
   {
      $task = Task::find()
         ->joinWith('city', 'category')
         ->where(['tasks.id' => $id])
         ->one();

      if (!$task) {
         throw new NotFoundHttpException;
      }

      return $this->render('view', [
         'task' => $task
      ]);
   }
}