<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $data SmsInbox
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('inbox_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->inbox_id), array('view', 'id'=>$data->inbox_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('smsc_source')); ?>:</b>
	<?php echo CHtml::encode($data->smsc_source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('smsc_sender')); ?>:</b>
	<?php echo CHtml::encode($data->smsc_sender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_nomor')); ?>:</b>
	<?php echo CHtml::encode($data->sender_nomor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('readed')); ?>:</b>
	<?php echo CHtml::encode($data->readed); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('queue_no')); ?>:</b>
	<?php echo CHtml::encode($data->queue_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php echo CHtml::encode($data->group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reply')); ?>:</b>
	<?php echo CHtml::encode($data->reply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_date')); ?>:</b>
	<?php echo CHtml::encode($data->message_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('c_timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->c_timestamp); ?>
	<br />

	*/ ?>

</div>