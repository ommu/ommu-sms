<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this OutboxController
 * @var $model SmsOutbox
 * @var $form CActiveForm
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
		$model->smslog_id=>array('view','id'=>$model->smslog_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>