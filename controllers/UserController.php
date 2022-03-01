<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\Category;
use app\models\TaskSearchForm;
use app\models\City;
use app\models\Response;
use app\models\User;
use app\models\Auth;
use yii\web\Controller;
use app\controllers\AppController;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\authclient\clients\VKontakte;

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

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client) 
    {
      $attributes = $client->getUserAttributes();
      
       /* @var $auth Auth */
       $auth = Auth::find()->where([
         'source' => $client->getId(),
         'sourse_id' => $attributes['id'],
     ])->one();

     if (Yii::$app->user->isGuest) {
         if ($auth) { // авторизация
            $user = $auth->iser;
            Yii::$app->user->login($user);
         } else {
            $password = Yii::$app->security->generateRandomString(6);
            $user = new User();
               if (isset($attributes['first_name'], $attributes['last_name'])) {
               $user->user_name = implode(' ', array($attributes['first_name'], $attributes['last_name']));
               }
               if (isset($attributes['email'])) {
                  $user->email = $attributes['email'];
               } else {
                  $user->email = $attributes['id'] . '@taskforce.com';
               }
               $user->user_password = $password;
               $user->password_repeat = $password;
               $user->role_id = 0;
               $user->city_id = $attributes['city']['id'];
            
            if ($user->save()) {
               $auth = new Auth([
                   'iser_id' => $user->id,
                   'source' => $client->getId(),
                   'sourse_id' => $attributes['id'],
               ]);

               if ($auth->save()) {
                  Yii::$app->user->login($user);
                  $this->redirect('/tasks');
               }
            }
         }
      }
   }
}