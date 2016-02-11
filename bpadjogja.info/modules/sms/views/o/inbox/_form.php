<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'sms-inbox-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'user_id'); ?>
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
		<?php echo $form->labelEx($model,'smsc_sender'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'smsc_sender',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'smsc_sender'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'sender_nomor'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'sender_nomor',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'sender_nomor'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'message'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'message'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'readed'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'readed'); ?>
			<?php echo $form->error($model,'readed'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'queue_no'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'queue_no'); ?>
			<?php echo $form->error($model,'queue_no'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'group'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'group'); ?>
			<?php echo $form->error($model,'group'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'reply'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'reply'); ?>
			<?php echo $form->error($model,'reply'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'message_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->message_date != '0000-00-00' ? $model->message_date = date('d-m-Y', strtotime($model->message_date)) : '') : '';
			//echo $form->textField($model,'message_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'message_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'message_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'creation_date'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'creation_date'); ?>
			<?php echo $form->error($model,'creation_date'); ?>
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

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


