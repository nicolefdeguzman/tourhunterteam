<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter your nickname to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>
        <div class="row">
            <div class="col-lg-4">
            <hr>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'width' => '100%'])->label('Nickname : ') ?>
            <hr>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
