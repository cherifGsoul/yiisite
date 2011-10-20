<?php
$this->breadcrumbs=array(
	'Taxonomys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Taxonomy', 'url'=>array('index')),
	array('label'=>'Manage Taxonomy', 'url'=>array('admin')),
);
?>

<h1>Create Taxonomy</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>