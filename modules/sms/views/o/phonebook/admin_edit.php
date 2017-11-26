<?php
/**
 * Sms Phonebooks (sms-phonebook)
 * @var $this PhonebookController
 * @var $model SmsPhonebook
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 17:31 WIB
 * @link https://github.com/ommu/ommu-sms
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Sms Phonebooks'=>array('manage'),
		$model->phonebook_id=>array('view','id'=>$model->phonebook_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>