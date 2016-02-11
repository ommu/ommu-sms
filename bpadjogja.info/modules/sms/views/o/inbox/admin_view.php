<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
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
			//'value'=>'value'=>$model->inbox_id != '' ? $model->inbox_id : '-',
		),
		array(
			'name'=>'user_id',
			'value'=>$model->user_id,
			//'value'=>'value'=>$model->user_id != '' ? $model->user_id : '-',
		),
		array(
			'name'=>'smsc_source',
			'value'=>$model->smsc_source,
			//'value'=>'value'=>$model->smsc_source != '' ? $model->smsc_source : '-',
		),
		array(
			'name'=>'smsc_sender',
			'value'=>$model->smsc_sender,
			//'value'=>'value'=>$model->smsc_sender != '' ? $model->smsc_sender : '-',
		),
		array(
			'name'=>'sender_nomor',
			'value'=>$model->sender_nomor,
			//'value'=>'value'=>$model->sender_nomor != '' ? $model->sender_nomor : '-',
		),
		array(
			'name'=>'message',
			'value'=>'value'=>$model->message != '' ? $model->message : '-',
			//'value'=>'value'=>$model->message != '' ? CHtml::link($model->message, Yii::app()->request->baseUrl.'/public/visit/'.$model->message, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'readed',
			'value'=>$model->readed,
			//'value'=>'value'=>$model->readed != '' ? $model->readed : '-',
		),
		array(
			'name'=>'queue_no',
			'value'=>$model->queue_no,
			//'value'=>'value'=>$model->queue_no != '' ? $model->queue_no : '-',
		),
		array(
			'name'=>'group',
			'value'=>$model->group,
			//'value'=>'value'=>$model->group != '' ? $model->group : '-',
		),
		array(
			'name'=>'reply',
			'value'=>$model->reply,
			//'value'=>'value'=>$model->reply != '' ? $model->reply : '-',
		),
		array(
			'name'=>'message_date',
			'value'=>Utility::dateFormat($model->message_date, true),
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'c_timestamp',
			'value'=>$model->c_timestamp,
			//'value'=>'value'=>$model->c_timestamp != '' ? $model->c_timestamp : '-',
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
