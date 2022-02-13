<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use app\models\EntryForm;

class LandingController extends Controller 
{
   public $layout = 'landing';

   public function actionIndex() 
   {
      $model = new EntryForm;

      if (\Yii::$app->request->getIsPost()) {
         $model->load(\Yii::$app->request->post());
         if ($model->validate()) {
             $user = $model->getUser();
             \Yii::$app->user->login($user);
             return $this->redirect('/tasks');
         }
     }

      return $this->render('index', ['model' => $model]);
   }

   public function actionLogin()
   {
       $loginForm = new EntryForm();
       if (\Yii::$app->request->getIsPost()) {
           $loginForm->load(\Yii::$app->request->post());
           if ($loginForm->validate()) {
               $user = $loginForm->getUser();
               \Yii::$app->user->login($user);
               return $this->redirect('/tasks');
           }
       }
   }
}