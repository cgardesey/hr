<?php
/* @var $this TodoController */
/* @var $model Todo */

$this->breadcrumbs=array(
	'Todos'=>array('index'),
	$model->todoid,
);

$this->menu=array(
	array('label'=>'List Todo', 'url'=>array('index')),
	array('label'=>'Create Todo', 'url'=>array('create')),
	array('label'=>'Update Todo', 'url'=>array('update', 'id'=>$model->todoid)),
	array('label'=>'Delete Todo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->todoid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Todo', 'url'=>array('admin')),
);
?>

<h1>View Todo #<?php echo $model->todoid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'todoid',
		'todo_content',
		'institutionid',
	),
)); ?>
