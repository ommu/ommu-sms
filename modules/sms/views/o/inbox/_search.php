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

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('inbox_id'); ?><br/>
			<?php echo $form->textField($model,'inbox_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('smsc_source'); ?><br/>
			<?php echo $form->textField($model,'smsc_source',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('smsc_sender'); ?><br/>
			<?php echo $form->textField($model,'smsc_sender',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('sender_nomor'); ?><br/>
			<?php echo $form->textField($model,'sender_nomor',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message'); ?><br/>
			<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
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
