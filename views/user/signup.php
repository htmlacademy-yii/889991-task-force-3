<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
   
$this->title = 'Форма регистрации';

?>

<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $form = ActiveForm::begin(['id' => 'signup-form']) ?>
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <div class="form-group">
                    <?= $form->field($model, 'user_name')->label('Ваше имя', ['class' => 'control-label']); ?>
                </div>
                <div class="half-wrapper">
                    <div class="form-group">
                    <?= $form->field($model, 'email')->input('email')->label('Email', ['class' => 'control-label']); ?>
                    </div>
                    <div class="form-group">
                    <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'name'), ['prompt' => '']); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                <?= $form->field($model, 'user_password')->passwordInput()->label('Пароль', ['class' => 'control-label']); ?>
                </div>
                <div class="form-group">
                <?= $form->field($model, 'password_repeat')->passwordInput()->label('Повтор пароля', ['class' => 'control-label']); ?>
                </div>
                <div class="form-group">
                <?= $form->field($model, 'role_id', ['template' => "{input}\n{label}"])->checkbox($options = ['value' => 1,], $enclosedByLabel = false)->label('я собираюсь откликаться на заказы') ?>
                </div>
                <?= Html::submitButton('Создать аккаунт', ['class' => 'button button--blue', 'style' => 'width: 660px;']) ?>
                <?php ActiveForm::end() ?>
        </div>
    </div>
</main>