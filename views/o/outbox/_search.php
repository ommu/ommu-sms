<?php
/**
 * View Sms Outboxes (view-sms-outbox)
 * @var $this OutboxController
 * @var $model ViewSmsOutbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 15 February 2016, 11:43 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('outbox_id'); ?><br/>
			<?php echo $form->textField($model,'outbox_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('status'); ?><br/>
			<?php echo $form->textField($model,'status'); ?>
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
			<?php echo $model->getAttributeLabel('message'); ?><br/>
			<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('sents'); ?><br/>
			<?php echo $form->textField($model,'sents',array('size'=>21,'maxlength'=>21)); ?>
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
			<?php echo $model->getAttributeLabel('noted'); ?><br/>
			<?php echo $form->textField($model,'noted',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
