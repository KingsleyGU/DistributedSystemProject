<?php
/* @var $this RecipeIngredientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Recipe Ingredients',
);

$this->menu=array(
	array('label'=>'Create RecipeIngredient', 'url'=>array('create')),
	array('label'=>'Manage RecipeIngredient', 'url'=>array('admin')),
);
?>

<h1>Recipe Ingredients</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
