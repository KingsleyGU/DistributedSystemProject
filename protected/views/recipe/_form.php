<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'recipeId'); ?>
		<?php echo $form->textField($model,'recipeId',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'recipeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'webUrl'); ?>
		<?php echo $form->textField($model,'webUrl',array('size'=>60,'maxlength'=>180)); ?>
		<?php echo $form->error($model,'webUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imageUrl'); ?>
		<?php echo $form->textField($model,'imageUrl',array('size'=>60,'maxlength'=>180)); ?>
		<?php echo $form->error($model,'imageUrl'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->