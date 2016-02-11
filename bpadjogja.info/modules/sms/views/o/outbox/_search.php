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

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('smslog_id'); ?><br/>
			<?php echo $form->textField($model,'smslog_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('status'); ?><br/>
			<?php echo $form->textField($model,'status'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('group_id'); ?><br/>
			<?php echo $form->textField($model,'group_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('reply_id'); ?><br/>
			<?php echo $form->textField($model,'reply_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('smsc_source'); ?><br/>
			<?php echo $form->textField($model,'smsc_source',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('destination_nomor'); ?><br/>
			<?php echo $form->textField($model,'destination_nomor',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('destination_message'); ?><br/>
			<?php echo $form->textArea($model,'destination_message',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('updated_date'); ?><br/>
			<?php echo $form->textField($model,'updated_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('reply_date'); ?><br/>
			<?php echo $form->textField($model,'reply_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('c_timestamp'); ?><br/>
			<?php echo $form->textField($model,'c_timestamp'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
