<?php
/**
 * View Sms Outboxes (view-sms-outbox)
 * @var $this OutboxController
 * @var $model ViewSmsOutbox
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 15 February 2016, 11:43 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'View Sms Outboxes'=>array('manage'),
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
			'name'=>'destination_nomor',
			'value'=>$model->destination_nomor,
		),
		array(
			'name'=>'message',
			'value'=>$model->message != '' ? $model->message : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'sents',
			'value'=>$model->sents,
		),
		array(
			'name'=>'smsc_source',
			'value'=>$model->smsc_source,
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
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
