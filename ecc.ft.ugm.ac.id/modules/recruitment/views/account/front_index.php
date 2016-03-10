<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'recruitment-users-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<fieldset>
	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'email'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'email',array('maxlength'=>32)); ?>
			<?php echo $form->error($model,'email'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'displayname'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'displayname',array('maxlength'=>64)); ?>
			<?php echo $form->error($model,'displayname'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'photos'); ?>
		<div class="desc">
			<?php echo $form->fileField($model,'photos'); ?>
			<?php echo $form->error($model,'photos'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>
