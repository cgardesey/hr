<?php
/* @var $this TodoController */
/* @var $model Todo */

$this->breadcrumbs=array(
	'Todos'=>array('index'),
	$model->todoid=>array('view','id'=>$model->todoid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Todo', 'url'=>array('index')),
	array('label'=>'Create Todo', 'url'=>array('create')),
	array('label'=>'View Todo', 'url'=>array('view', 'id'=>$model->todoid)),
	array('label'=>'Manage Todo', 'url'=>array('admin')),
);
?>

<h1>Update Todo <?php echo $model->todoid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>