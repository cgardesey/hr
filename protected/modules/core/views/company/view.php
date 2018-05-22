<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->companyid,
);

$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),
	array('label'=>'Update Company', 'url'=>array('update', 'id'=>$model->companyid)),
	array('label'=>'Delete Company', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->companyid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);
?>

<h1>View Company #<?php echo $model->companyid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'companyid',
		'company_name',
		'company_address',
		'company_email',
		'company_phone',
		'company_mobile',
		'company_fax',
		'company_contactperson',
		'company_country',
		'company_state',
		'company_currency',
		'company_language',
		'company_code',
		'company_timezone',
		'company_logo',
	),
)); ?>
