<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\User;
use app\models\Category;
use app\models\TaskSearchForm;
use app\models\City;
use app\models\File;
use app\models\Response;
use app\models\Review;
use yii\web\Controller;
use app\controllers\AppController;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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

   public function actionView($id) 
   {
      $task = Task::find()
         ->joinWith('city', 'category')
         ->where(['tasks.id' => $id])
         ->one();

      if (!$task) {
         throw new NotFoundHttpException;
      }

      $model = new Response();
      if (Yii::$app->request->isPost) {
         $model->load(\Yii::$app->request->post());
         if ($model->validate()) {
         $model->task_id = $task->id;
         $model->user_id = \Yii::$app->user->getId();
         $model->save();
         }
      }

      $done = new Review();
      if (Yii::$app->request->isPost) {
         $done->load(\Yii::$app->request->post());
         if ($done->validate()) {
         $done->task_id = $task->id;
         $done->user_id = $task->user_id;
         //$done->executor_id = $task->executor_id;
         $done->save(false);
         $task->task_status = 'done';
         $task->save();
         }
      }
      $responses = Response::find()
      ->where(['task_id' => $id])
      ->all();

      if ($id = \Yii::$app->user->getId()) {
         $user = User::findOne($id);
         
         $action = new \Taskforce\logic\Task($task->task_status, $id, $task->user_id, $task->executor_id);
         $action->getAvailableActions($user->role->role_name);
      }
      
      return $this->render('view', [
         'task' => $task,
         'model' => $model,
         'responses' => $responses,
         'done' => $done,
         'action' => $action
      ]);
   }

   public function actionAccept(int $id) 
   {
      $response = Response::findOne($id);
      $task = Task::findOne($response->task_id);
      $executor = User::findOne($response->user_id);

      if (!$task || !$executor || !$response) {
         throw new DataException('Данное действие не может быть выполнено!');
     }

     $task->task_status = 'working';
     $task->executor_id = $executor->id;
     $task->save();

     $response->status = 'accepted';
     $response->save();

     $this->redirect('/tasks/view/' . $response->task_id);
   }

   public function actionRefuse(int $id) 
   {
      $response = Response::findOne($id);
      $response->status = 'refused';
      $response->save(false);

      $this->redirect('/tasks/view/' . $response->task_id);
   }

   public function actionRejection(int $id) 
   {
      $task = Task::findOne($id);
      $task->task_status = 'done';
      $task->save();

      $this->redirect('/tasks/view/' . $task->id);
   }
   public function actionCancel(int $id) 
   {
      $task = Task::findOne($id);
      $task->task_status = 'canceled';
      $task->save();

      $this->redirect('/tasks/view/' . $task->id);
   }

   public function actionFormalization() 
   {
      $model = new Task;

      $categories = Category::find()->all();

      if (Yii::$app->request->isPost) {
         $model->load(\Yii::$app->request->post());
         $model->files = UploadedFile::getInstances($model, 'files');
         if ($model->validate()) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->save();
            if (isset($model->files)) {
               foreach ($model->files as $file) {
                  $user_file = new File;
                  $user_file->task_id = $model->id;
                  $user_file->file_path = 'uploads/' . $file->baseName . '.' . $file->extension;
                  $user_file->save();
                  $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            }
            $this->redirect('/tasks/view/' . $model->id);
         }
         
     }

      return $this->render('formalization', ['model' => $model, 'categories' => $categories]);
   }
}