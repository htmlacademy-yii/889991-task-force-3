<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\Category;
use app\models\TaskSearchForm;
use app\models\City;
use app\models\Response;
use app\models\User;
use yii\web\Controller;
use app\controllers\AppController;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class UserController extends Controller 
{
   public function actionView($id)
   {
      $user = User::find()
      ->where(['id' => $id])
      ->one();
      if (!$user) {
         throw new NotFoundHttpException("Исполнитель не найден!");
     }

      return $this->render('view', ['user' => $user]);
   }
}