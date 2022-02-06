<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

class AppController extends Controller 
{
   public static function debug($arr) 
   {
      echo '<pre>' . print_r($arr, true) . '</pre>';
   }

}