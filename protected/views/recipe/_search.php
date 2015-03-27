<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recipeId'); ?>
		<?php echo $form->textField($model,'recipeId',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'webUrl'); ?>
		<?php echo $form->textField($model,'webUrl',array('size'=>60,'maxlength'=>180)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imageUrl'); ?>
		<?php echo $form->textField($model,'imageUrl',array('size'=>60,'maxlength'=>180)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->