<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\History */

/* @var $this yii\web\View */
$this->registerJs("$(function() {
   $('#popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content')
     .load($(this).attr('href'));
   });
});");
$this->title = 'Transfer to '.$model->receivers->username;
$this->params['breadcrumbs'][] = ['label' => 'Test Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
    	<div class="col-lg-4">
    		
	    <?php $form = ActiveForm::begin(); ?>
	    <hr>
	    <?= $form->field($model, 'amount')->textInput(['type' => 'decimal']) ?>
		<hr>
	    <div class="form-group">
	        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>
    	</div>
    </div>

</div>
