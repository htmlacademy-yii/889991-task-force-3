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
use yii\filters\AccessControl;

class UserController extends Controller 
{
   public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

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

   public function actionSignup() 
   {
      $user = new User();
      if (Yii::$app->request->getIsPost()) {
         $user->load(Yii::$app->request->post());
         if ($user->validate()) {
            $user->user_password = Yii::$app->security->generatePasswordHash($user->user_password);
            $user->save(false);
            \Yii::$app->user->login($user);
            $this->redirect('/tasks'); 
            
         }
      }
      $cities = City::find()->all();

      return $this->render('signup', ['model' => $user, 'cities'=> $cities]);
   }

   public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect('/landing');
    }
}