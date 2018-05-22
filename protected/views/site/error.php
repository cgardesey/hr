<?php
/* @var $this SiteController */
/* @var $error array */
Yii::app()->clientScript->registerCoreScript('jquery');

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>