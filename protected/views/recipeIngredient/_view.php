<?php
/* @var $this RecipeIngredientController */
/* @var $data RecipeIngredient */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipeId')); ?>:</b>
	<?php echo CHtml::encode($data->recipeId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ingredients')); ?>:</b>
	<?php echo CHtml::encode($data->ingredients); ?>
	<br />


</div>