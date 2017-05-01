<?php
/**
 * Sms Groups (sms-groups)
 * @var $this GroupController
 * @var $model SmsGroups
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 18:27 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Sms Groups'=>array('manage'),
		$model->group_id=>array('view','id'=>$model->group_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'phonebook'=>$phonebook,
	)); ?>
</div>
