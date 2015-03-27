<?php
/* @var $this RecipeIngredientController */
/* @var $model RecipeIngredient */

$this->breadcrumbs=array(
	'Recipe Ingredients'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RecipeIngredient', 'url'=>array('index')),
	array('label'=>'Create RecipeIngredient', 'url'=>array('create')),
	array('label'=>'View RecipeIngredient', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RecipeIngredient', 'url'=>array('admin')),
);
?>

<h1>Update RecipeIngredient <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>