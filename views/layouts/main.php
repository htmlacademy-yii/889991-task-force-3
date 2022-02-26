<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=e666f398-c983-4bde-8f14-e3fec900592a&lang=ru_RU" type="text/javascript"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

   <header class="page-header">
      <nav class="main-nav">
         <a href='<?= Url::to('/tasks') ?>' class="header-logo">
            <img class="logo-image" src="/img/logotype.png" width=227 height=60 alt="taskforce">
         </a>
         <?php if (Url::current() !== Url::to(['user/signup'])) : ?>
         <div class="nav-wrapper">
            <ul class="nav-list">
               <li class="list-item list-item--active">
                  <a class="link link--nav" href="<?= Url::to(['tasks/index']) ?>">Новое</a>
               </li>
               <li class="list-item">
                  <a href="#" class="link link--nav">Мои задания</a>
               </li>
               <li class="list-item">
                  <a href="<?= Url::to(['/tasks/formalization']) ?>" class="link link--nav">Создать задание</a>
               </li>
               <li class="list-item">
                  <a href="#" class="link link--nav">Настройки</a>
               </li>
            </ul>
         </div>
         <?php endif; ?>
      </nav>
      <?php if (Url::current() !== Url::to(['user/signup'])) : ?>
      <div class="user-block">
         <a href="#">
            <img class="user-photo" src="/img/man-glasses.png" width="55" height="55" alt="Аватар">
         </a>
         <div class="user-menu">
            <p class="user-name">
            <?php if (isset(Yii::$app->user->identity->user_name)): ?>
               <?= Html::encode(Yii::$app->user->identity->user_name); ?>
            <?php endif; ?>
            </p>
            <div class="popup-head">
               <ul class="popup-menu">
                  <li class="menu-item">
                     <a href="#" class="link">Настройки</a>
                  </li>
                  <li class="menu-item">
                     <a href="#" class="link">Связаться с нами</a>
                  </li>
                  <li class="menu-item">
                     <a href="<?= Url::to('/user/logout'); ?>" class="link">Выход из системы</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </header>
   
      <?= $content; ?>
   

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
