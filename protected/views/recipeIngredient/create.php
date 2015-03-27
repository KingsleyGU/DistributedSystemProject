<?php
/* @var $this RecipeIngredientController */
/* @var $model RecipeIngredient */

$this->breadcrumbs=array(
	'Recipe Ingredients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RecipeIngredient', 'url'=>array('index')),
	array('label'=>'Manage RecipeIngredient', 'url'=>array('admin')),
);
?>

<h1>Create RecipeIngredient</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>