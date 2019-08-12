<?php
/**
 * Sms Inboxes (sms-inbox)
 * @var $this InboxController
 * @var $model SmsInbox
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'Sms Inboxes'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>