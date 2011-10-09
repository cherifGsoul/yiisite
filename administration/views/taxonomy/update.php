<?php
$this->breadcrumbs=array(
	'Taxonomys'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Taxonomy', 'url'=>array('index')),
	array('label'=>'Create Taxonomy', 'url'=>array('create')),
	array('label'=>'View Taxonomy', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Taxonomy', 'url'=>array('admin')),
);
?>

<h1>Update Taxonomy <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>