<?php
/* @var $this TodoController */
/* @var $data Todo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('todoid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->todoid), array('view', 'id'=>$data->todoid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('todo_content')); ?>:</b>
	<?php echo CHtml::encode($data->todo_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('institutionid')); ?>:</b>
	<?php echo CHtml::encode($data->institutionid); ?>
	<br />


</div>