<?php
/* @var $this RecipeController */
/* @var $data Recipe */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipeId')); ?>:</b>
	<?php echo CHtml::encode($data->recipeId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('webUrl')); ?>:</b>
	<?php echo CHtml::encode($data->webUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imageUrl')); ?>:</b>
	<?php echo CHtml::encode($data->imageUrl); ?>
	<br />


</div>