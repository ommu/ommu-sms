<?php
/**
 * Recruitments (recruitments)
 * @var $this ScannerController
 * @var $data Recruitments
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 March 2016, 23:23 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('recruitment_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->recruitment_id), array('view', 'id'=>$data->recruitment_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish')); ?>:</b>
	<?php echo CHtml::encode($data->publish); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_name')); ?>:</b>
	<?php echo CHtml::encode($data->event_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_desc')); ?>:</b>
	<?php echo CHtml::encode($data->event_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_type')); ?>:</b>
	<?php echo CHtml::encode($data->event_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_logo')); ?>:</b>
	<?php echo CHtml::encode($data->event_logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('finish_date')); ?>:</b>
	<?php echo CHtml::encode($data->finish_date); ?>
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