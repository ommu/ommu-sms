<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link https://github.com/ommu/mod-sms
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('inbox_id'); ?><br/>
			<?php echo $form->textField($model,'inbox_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('phonebook_id'); ?><br/>
			<?php echo $form->textField($model,'phonebook_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('smsc_source'); ?><br/>
			<?php echo $form->textField($model,'smsc_source'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('smsc_sender'); ?><br/>
			<?php echo $form->textField($model,'smsc_sender'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('sender_nomor'); ?><br/>
			<?php echo $form->textField($model,'sender_nomor'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message'); ?><br/>
			<?php echo $form->textArea($model,'message'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('readed'); ?><br/>
			<?php echo $form->textField($model,'readed'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('queue_no'); ?><br/>
			<?php echo $form->textField($model,'queue_no'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('group'); ?><br/>
			<?php echo $form->textField($model,'group'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('reply'); ?><br/>
			<?php echo $form->textField($model,'reply'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_date'); ?><br/>
			<?php echo $form->textField($model,'message_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('c_timestamp'); ?><br/>
			<?php echo $form->textField($model,'c_timestamp'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
