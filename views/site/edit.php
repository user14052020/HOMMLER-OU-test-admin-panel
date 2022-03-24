<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	'id' => 'edit-form',
	'options' => ['class' => 'form-horizontal'],

])?>

	<?= $form->field($model,'imageFile')->fileInput() ?>
	<?= $form->field($model,'sku') ?>
	<?= $form->field($model,'name') ?>
	<?= $form->field($model,'count') ?>
	<?= $form->field($model,'type') ?>
	<?= Html::submitButton('Сохранить',['class' => 'btn btn-primary'])?>

<?php $form = ActiveForm::end() ?>