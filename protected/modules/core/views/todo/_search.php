<?php
/* @var $this TodoController */
/* @var $model Todo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'todoid'); ?>
		<?php echo $form->textField($model,'todoid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'todo_content'); ?>
		<?php echo $form->textArea($model,'todo_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'institutionid'); ?>
		<?php echo $form->textField($model,'institutionid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->