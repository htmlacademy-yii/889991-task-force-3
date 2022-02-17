<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<main class="main-content main-content--center container">
      <div class="add-task-form regular-form">
      <?php $form = ActiveForm::begin(['id' => 'create_task-form']) ?>
            <h3 class="head-main head-main">Публикация нового задания</h3>
            <div class="form-group">
            <?= $form->field($model, 'title')->label('Опишите суть работы', ['class' => 'control-label']); ?>
            </div>
            <div class="form-group">
            <?= $form->field($model, 'task_description')->textarea()->label('Подробности задания', ['class' => 'control-label']); ?>   
            </div>
            <div class="form-group">
            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['prompt' => ''])
            ->label('Категория', ['class' => 'control-label']); ?>
            </div>
            <div class="form-group">
            <?= $form->field($model, 'task_location')->label('Локация', ['class' => 'control-label']); ?>
            </div>
            <div class="half-wrapper">
               <div class="form-group">
               <?= $form->field($model, 'budget')->input('number')->label('Бюджет', ['class' => 'control-label']); ?>
               </div>
               <div class="form-group">
               <?= $form->field($model, 'period_execution')->input('date')->label('Срок исполнения', ['class' => 'control-label']); ?>
               </div>
            </div>
            <div class="form-group ">
            <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'class' => "new-file"])->label('Файлы', ['class' => 'control-label']); ?>   
            </div>
            <?= Html::submitButton('Опубликовать', ['class' => 'button button--blue']) ?>
            <?php ActiveForm::end() ?>
      </div>
   </main>