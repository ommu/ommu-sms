<?php
/**
 * View Sms Outboxes (view-sms-outbox)
 * @var $this OutboxController
 * @var $model ViewSmsOutbox
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 15 February 2016, 11:43 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'View Sms Outboxes'=>array('manage'),
		$model->outbox_id,
	);
?>

<div class="dialog-content">
<?php $this->widget('zii.widgets.CDetailView', array(
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
			'value'=>$this->dateFormat($model->creation_date),
		),
		array(
			'name'=>'creation_search',
			'value'=>$model->noted != "" ? $model->noted : $model->creation_TO->displayname,
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
