<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this OutboxController
 * @var $model SmsOutbox
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 04:07 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Sms Outboxes'=>array('manage'),
		$model->outbox_id,
	);
?>

<div class="dialog-content">
<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'outbox_id',
			'value'=>$model->outbox_id,
		),
		array(
			'name'=>'status',
			'value'=>$model->status == 0 ? "Pending" : ($model->status == 1 ? "Sent" : ($model->status == 2 ? "Failed" : "Delivered")),
		),
		array(
			'name'=>'group_id',
			'value'=>$model->group_id,
		),
		array(
			'name'=>'destination_nomor',
			'value'=>$model->destination_nomor,
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
			'name'=>'smsc_destination',
			'value'=>$model->smsc_destination,
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->noted != "" ? $model->noted : $model->creation_TO->displayname,
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
