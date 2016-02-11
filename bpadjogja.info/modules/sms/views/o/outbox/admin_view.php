<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this OutboxController
 * @var $model SmsOutbox
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 11 February 2016, 18:56 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Sms Outboxes'=>array('manage'),
		$model->smslog_id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'smslog_id',
			'value'=>$model->smslog_id,
			//'value'=>'value'=>$model->smslog_id != '' ? $model->smslog_id : '-',
		),
		array(
			'name'=>'status',
			'value'=>$model->status == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			//'value'=>$model->status,
		),
		array(
			'name'=>'user_id',
			'value'=>$model->user_id,
			//'value'=>'value'=>$model->user_id != '' ? $model->user_id : '-',
		),
		array(
			'name'=>'group_id',
			'value'=>$model->group_id,
			//'value'=>'value'=>$model->group_id != '' ? $model->group_id : '-',
		),
		array(
			'name'=>'reply_id',
			'value'=>$model->reply_id,
			//'value'=>'value'=>$model->reply_id != '' ? $model->reply_id : '-',
		),
		array(
			'name'=>'smsc_source',
			'value'=>$model->smsc_source,
			//'value'=>'value'=>$model->smsc_source != '' ? $model->smsc_source : '-',
		),
		array(
			'name'=>'destination_nomor',
			'value'=>$model->destination_nomor,
			//'value'=>'value'=>$model->destination_nomor != '' ? $model->destination_nomor : '-',
		),
		array(
			'name'=>'destination_message',
			'value'=>'value'=>$model->destination_message != '' ? $model->destination_message : '-',
			//'value'=>'value'=>$model->destination_message != '' ? CHtml::link($model->destination_message, Yii::app()->request->baseUrl.'/public/visit/'.$model->destination_message, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id,
			//'value'=>'value'=>$model->creation_id != '' ? $model->creation_id : '-',
		),
		array(
			'name'=>'updated_date',
			'value'=>Utility::dateFormat($model->updated_date, true),
		),
		array(
			'name'=>'reply_date',
			'value'=>Utility::dateFormat($model->reply_date, true),
		),
		array(
			'name'=>'c_timestamp',
			'value'=>$model->c_timestamp,
			//'value'=>'value'=>$model->c_timestamp != '' ? $model->c_timestamp : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
