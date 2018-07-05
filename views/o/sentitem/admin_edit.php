<?php
/**
 * Sms Outboxes (sms-outbox)
 * @var $this SentitemController
 * @var $model SmsOutbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 04:07 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'Sms Outboxes'=>array('manage'),
		$model->outbox_id=>array('view','id'=>$model->outbox_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>