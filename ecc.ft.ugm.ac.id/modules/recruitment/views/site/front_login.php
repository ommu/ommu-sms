<?php
/**
 * @var $this SiteController
 * @var $model LoginForm
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Login',
	);
?>

<div name="post-on">
<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<fieldset>
		<div class="clearfix">
			<?php if(isset($_GET['event'])) {?>
				<?php echo $form->textField($model,'email', array('maxlength'=>32, 'placeholder'=>'Test Number')); ?>
			<?php } else {?>
				<?php echo $form->textField($model,'email', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('email'))); ?>
			<?php }?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="clearfix">
			<?php echo $form->passwordField($model,'password', array('maxlength'=>32, 'placeholder'=>$model->getAttributeLabel('password'))); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
		<div class="clearfix">
			<?php echo CHtml::submitButton('Login', array('onclick' => 'setEnableSave()', 'class'=>'blue-button')); ?>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
</div>
