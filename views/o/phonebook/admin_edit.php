<?php
/**
 * Sms Phonebooks (sms-phonebook)
 * @var $this PhonebookController
 * @var $model SmsPhonebook
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 17:31 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'Sms Phonebooks'=>array('manage'),
		$model->phonebook_id=>array('view','id'=>$model->phonebook_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>