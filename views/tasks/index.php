<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
   
$this->title = 'Задания';
?>
<main class="main-content container">
   <div class="left-column">
      <h3 class="head-main head-task">Новые задания</h3>
      <?php if (count($tasks) > 0): ?>
         <?php foreach ($tasks as $task): ?>
         <div class="task-card">
            <div class="header-task">
               <a  href="<?= Url::to(['tasks/view', 'id' => $task->id]) ?>" class="link link--block link--big">
                  <?= Html::encode($task->title) ?>
               </a>
               <p class="price price--task"><?= Html::encode($task->budget) ?> ₽</p>
            </div>
            <p class="info-text">
               <span class="current-time">
                  <?= Yii::$app->formatter->format(
                     $task->date_creation,
                     'relativeTime'
                  ) ?>
               </span>
            </p>
            <p class="task-text">
               <?= Html::encode($task->task_description) ?>
            </p>
            <div class="footer-task">
               <p class="info-text town-text">
               <?php if (isset($task->city->name)): ?>
                   <?= Html::encode($task->city->name) ?>
               <?php else: ?>
                  Удаленная работа    
               <?php endif; ?>    
               </p>
                <p class="info-text category-text"><?= Html::encode($task->category->name) ?></p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="right-column">
       <div class="right-card black">
           <div class="search-form">
           <?php $form = ActiveForm::begin([
                'id' => 'search-form',
                'fieldConfig' => [
                    'template' => "{input}\n{label}"
                ]
            ]) ?>
                    <h4 class="head-card">Категории</h4>
                    <div class="form-group">
                    <?php foreach ($categories as $category): ?>
                       <?= $form->field($model, 'categories[]')->checkbox($options = ['value' => $category->id,'checked'=> in_array($category->id, $model->categories)], $enclosedByLabel = false)->label($category->name) ?>
                       <?php endforeach; ?>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                    <?= $form->field($model, 'no_location')->checkbox($options = ['value' => 1, 'checked'=> false], $enclosedByLabel = false)->label('Удаленная работа') ?>
                    <?= $form->field($model, 'no_response')->checkbox($options = ['value' => 1, 'checked'=> false], $enclosedByLabel = false)->label('Без откликов') ?>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                    <?= $form->field($model, 'period', ['template' => "{input}"])->dropDownList($period_values, ['id' => 'period-value']) ?>
                    </div>
                    <?= Html::submitButton('Искать', ['class' => 'button button--blue']) ?>
                    <?php ActiveForm::end() ?>
           </div>
       </div>
    </div>
</main>