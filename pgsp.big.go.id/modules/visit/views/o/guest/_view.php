<?php
/**
 * Visit Guests (visit-guest)
 * @var $this GuestController
 * @var $data VisitGuest
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('guest_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->guest_id), array('view', 'id'=>$data->guest_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_date')); ?>:</b>
	<?php echo CHtml::encode($data->finish_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization')); ?>:</b>
	<?php echo CHtml::encode($data->organization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization_name')); ?>:</b>
	<?php echo CHtml::encode($data->organization_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization_address')); ?>:</b>
	<?php echo CHtml::encode($data->organization_address); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('organization_phone')); ?>:</b>
	<?php echo CHtml::encode($data->organization_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization_visitor')); ?>:</b>
	<?php echo CHtml::encode($data->organization_visitor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('messages')); ?>:</b>
	<?php echo CHtml::encode($data->messages); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_file')); ?>:</b>
	<?php echo CHtml::encode($data->message_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message_reply')); ?>:</b>
	<?php echo CHtml::encode($data->message_reply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_id')); ?>:</b>
	<?php echo CHtml::encode($data->creation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_id')); ?>:</b>
	<?php echo CHtml::encode($data->modified_id); ?>
	<br />

	*/ ?>

</div>