<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Sms Inboxes'=>array('manage'),
		$model->inbox_id,
	);
?>

<div class="dialog-content">
<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'inbox_id',
			'value'=>$model->inbox_id,
		),
		array(
			'name'=>'user_id',
			'value'=>$model->user_id,
		),
		array(
			'name'=>'sender_nomor',
			'value'=>$model->sender_nomor,
		),
		array(
			'name'=>'message',
			'value'=>$model->message != '' ? $model->message : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'smsc_source',
			'value'=>$model->smsc_source,
		),
		array(
			'name'=>'smsc_sender',
			'value'=>$model->smsc_sender,
		),
		/*
		array(
			'name'=>'message_date',
			'value'=>Utility::dateFormat($model->message_date, true),
		),
		*/
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
