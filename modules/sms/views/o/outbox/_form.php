<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this OutboxController
 * @var $model SmsOutbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 04:07 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('select#SmsOutbox_messageType').live('change', function() {
		var id = $(this).val();
		$('fieldset div.type').slideUp();
		if(id == '1') {
			$('div.type#single').slideDown();
		} else if(id == '2') {
			$('div.type#multi').slideDown();
		} else if(id == '3') {
			$('div.type#group').slideDown();
		}
	});
EOP;
	$cs->registerScript('type', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'sms-outbox-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => 'on_post',
	)
)); ?>
<div class="dialog-content">
	<fieldset>

		<?php 
		/*
		//begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages
		*/ ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'messageType'); ?>
			<div class="desc">
				<?php 
				if(isset($_GET['type']))
					$model->messageType  = $_GET['type'];
				echo $form->dropDownList($model,'messageType', array(
					'1' => 'Single',
					//'2' => 'Multi SMS',
					'3' => 'Group',
				)); ?>
				<?php echo $form->error($model,'messageType'); ?>
			</div>
		</div>

		<div id="single" class="type clearfix <?php echo (isset($_GET['type']) && $_GET['type'] == 1) || !isset($_GET['type']) ? '' : 'hide'?>">
			<label><?php echo $model->getAttributeLabel('contact_input');?> <span class="required">*</span></label>
			<div class="desc">
				<?php 
				//echo $form->textField($model,'contact_input',array('maxlength'=>15));
				$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'contact_input',
					'source' => Yii::app()->controller->createUrl('o/phonebook/suggest'),
					'options' => array(
						//'delay '=> 50,
						'minLength' => 1,
						'showAnim' => 'fold',
						'select' => "js:function(event, ui) {
							$('form #SmsOutbox_destination_nomor').val(ui.item.id);
						}"
					),
					'htmlOptions' => array(
						'class'	=> 'span-6',
					),
				));			
				echo $form->error($model,'contact_input');
				echo $form->hiddenField($model,'destination_nomor');
				?>
			</div>
		</div>

		<div id="multi" class="type clearfix <?php echo (isset($_GET['type']) && $_GET['type'] == 2) ? '' : 'hide'?>">
			<?php echo $form->labelEx($model,'multiple_input'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'multiple_input',array('maxlength'=>15)); ?>
				<?php echo $form->error($model,'multiple_input'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div id="group" class="type clearfix <?php echo (isset($_GET['type']) && $_GET['type'] == 3) ? '' : 'hide'?>">
			<label><?php echo $model->getAttributeLabel('group_input');?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->dropDownList($model,'group_input', SmsGroups::getGroup(1), array('prompt'=>'Pilih Group')); ?>
				<?php echo $form->error($model,'group_input'); ?>
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

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save')) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


