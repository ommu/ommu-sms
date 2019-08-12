<?php
/**
 * Sms Group Phonebooks (sms-group-phonebook)
 * @var $this GroupbookController
 * @var $model SmsGroupPhonebook
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 18:28 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 */

	$this->breadcrumbs=array(
		'Sms Group Phonebooks'=>array('manage'),
		Yii::t('phrase', 'Status'),
	);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sms-group-phonebook-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="dialog-content">
		<?php echo $model->status == 1 ? 'Are you sure you want to disable this item?' : 'Are you sure you want to enable this item?'?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($title, array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
