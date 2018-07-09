<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'Sms Inboxes'=>array('manage'),
		$model->inbox_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'inbox_id',
				'value'=>$model->inbox_id,
			),
			array(
				'name'=>'phonebook_id',
				'value'=>$model->phonebook_id && $model->phonebook->phonebook_name ? $model->phonebook->phonebook_name : $model->phonebook->phonebook_nomor,
			),
			array(
				'name'=>'sender_nomor',
				'value'=>$model->sender_nomor ? $model->sender_nomor : '-',
			),
			array(
				'name'=>'message',
				'value'=>$model->message ? $model->message : '-',
			),
			array(
				'name'=>'smsc_source',
				'value'=>$model->smsc_source ? $model->smsc_source : '-',
			),
			array(
				'name'=>'smsc_sender',
				'value'=>$model->smsc_sender ? $model->smsc_sender : '-',
			),
			array(
				'name'=>'message_date',
				'value'=>!in_array($model->message_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->message_date, true) : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date, true) : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
