<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this OutboxController
 * @var $model SmsOutbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 11 February 2016, 18:56 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'sms-outbox-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'group_id'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'group_id',array('size'=>11,'maxlength'=>11)); ?>
				<?php echo $form->error($model,'group_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'reply_id'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'reply_id',array('size'=>11,'maxlength'=>11)); ?>
				<?php echo $form->error($model,'reply_id'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'smsc_source'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'smsc_source',array('size'=>15,'maxlength'=>15)); ?>
				<?php echo $form->error($model,'smsc_source'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'destination_nomor'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'destination_nomor',array('size'=>15,'maxlength'=>15)); ?>
				<?php echo $form->error($model,'destination_nomor'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'destination_message'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'destination_message',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'destination_message'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'c_timestamp'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'c_timestamp'); ?>
				<?php echo $form->error($model,'c_timestamp'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


