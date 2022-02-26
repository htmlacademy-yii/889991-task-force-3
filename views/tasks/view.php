<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use Taskforce\logic\Task;
   
$this->title = 'Просмотр задания';

?>

<main class="main-content container">
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main"><?= Html::encode($task->title) ?></h3>
            <p class="price price--big"><?= Html::encode($task->budget) ?> ₽</p>
        </div>
        <p class="task-description">
        <?= Html::encode($task->task_description) ?>
        </p>
        <?php 
            $name = $action->currentAction;
            $mapActions = $action->getmapActions();
        ?>
        <?php if (isset($name)): ?>     
        <a href="#" class="button button--blue action-btn" data-action="<?= $name; ?>"><?= $mapActions[$name]; ?></a>
        <?php endif; ?>
        <div class="task-map">
            <div class="map" id="map"></div>
            <p class="map-address town">
            <?php if (isset($task->task_location)): ?>
                   <?= Html::encode($task->task_location) ?>
               <?php else: ?>
                  Удаленная работа    
               <?php endif; ?>
            </p>
            <!--<p class="map-address">Новый арбат, 23, к. 1</p>-->
        </div>
        <?php if (count($responses) > 0): ?>
        <h4 class="head-regular">Отклики на задание</h4>
        <?php foreach ($responses as $response): ?>
        <div class="response-card">
            <img class="customer-photo" src="/img/man-glasses.png" width="146" height="156" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <a href="<?= Url::to("/user/view/{$response->user_id}"); ?>" class="link link--block link--big"><?= Html::encode($response->user->user_name) ?></a>
                <div class="response-wrapper">
                    <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                    <p class="reviews">2 отзыва</p>
                </div>
                <p class="response-message">
                <?= Html::encode($response->coment) ?>
                </p>
            </div>
            <div class="feedback-wrapper">
                <p class="info-text"><span class="current-time"><?= Yii::$app->formatter->format($response->date_response,'relativeTime') ?></span></p>
                <p class="price price--small"><?= Html::encode($response->prise) ?> ₽</p>
            </div>
            <?php if (Yii::$app->user->id === $task->user_id && $task->task_status == 'new' && $response->status == 'new'): ?>
            <div class="button-popup">
                <a href="<?= Url::to(['tasks/accept', 'id' => $response->id ]); ?>" class="button button--blue button--small">Принять</a>
                <a href="<?= Url::to(['tasks/refuse', 'id' => $response->id ]); ?>" class="button button--orange button--small">Отказать</a>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        
    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
               <dt>Категория</dt>
               <dd><?= Html::encode($task->category->name) ?></dd>
               <dt>Дата публикации</dt>
               <dd>
                  <?= Html::encode(Yii::$app->formatter->format($task->date_creation, 'relativeTime')) ?>
               </dd>
                <dt>Срок выполнения</dt>
                <dd><?= Html::encode($task->period_execution) ?></dd>
                <dt>Статус</dt>
                <dd><?= Task::getMapStatuses(Html::encode($task->task_status)) ?></dd>
            </dl>
        </div>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                    <p class="file-size">356 Кб</p>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">information.docx</a>
                    <p class="file-size">12 Кб</p>
                </li>
            </ul>
        </div>
    </div>
</main>
<div class="regular-form pop-up pop-up--respond pop-up--close">
   <?php $form = ActiveForm::begin([
      'id' => 'response',
      'options' => ['autocomplete' => 'of'],
      ]) ?>
   <div class="half-wrapper">
      <div class="form-group">
         <?= $form->field($model, 'prise')->input('number')->label('Цена', ['class' => 'control-label']); ?>
      </div>
   </div>
   <div class="form-group">
      <?= $form->field($model, 'coment')->textarea()->label('Ваш коментарий', ['class' => 'control-label']); ?>   
   </div>
   <?= Html::submitButton('Откликнуться', ['class' => 'button button--blue']) ?>
   <?php ActiveForm::end() ?>
</div>
<div class="regular-form pop-up pop-up--done pop-up--close">
   <?php $form = ActiveForm::begin([
      'id' => 'done',
      'options' => ['autocomplete' => 'of'],
      ]) ?>
   <div class="half-wrapper">
      <div class="form-group">
         <?= $form->field($done, 'rating')->input('number')->label('Оценка', ['class' => 'control-label']); ?>
      </div>
   </div>
   <div class="form-group">
      <?= $form->field($done, 'coment')->textarea()->label('Оставьте отзыв', ['class' => 'control-label']); ?>   
   </div>
   <?= Html::submitButton('Задание завершено', ['class' => 'button button--blue']) ?>
   <?php ActiveForm::end() ?>
</div>
<div class="regular-form pop-up pop-up--rejection pop-up--close">
   <h2>Вы действительно хотите отказаться от задания?</h2>
   <a href="<?= Url::to(['tasks/view/' . $task->id ]); ?>" class="button button--blue">Я передумал, продолжаю</a>
   <a href="<?= Url::to(['tasks/rejection', 'id' => $task->id ]); ?>" class="button button--blue">Отказаться от задания</a>
</div>
<div class="regular-form pop-up pop-up--cancel pop-up--close">
   <h2>Вы действительно хотите отменить задание?</h2>
   <a href="<?= Url::to(['tasks/view/' . $task->id ]); ?>" class="button button--blue">Нет, пусть еще повисит</a>
   <a href="<?= Url::to(['tasks/cancel', 'id' => $task->id ]); ?>" class="button button--blue">Отказаться от задания</a>
</div>

<div class="overlay"></div>
<script type="text/javascript">
        ymaps.ready(init);
        function init(){
            var myMap = new ymaps.Map("map", {
                center: [<?= $task->long; ?>, <?= $task->lat; ?>],
                zoom: 17
            });
            var myPlacemark = new ymaps.Placemark([<?= $task->long; ?>, <?= $task->lat; ?>]);
            myMap.geoObjects.add(myPlacemark);
        }
    </script>