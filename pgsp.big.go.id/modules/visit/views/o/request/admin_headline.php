<?php
/**
 * Visit Request (visit-guest)
 * @var $this RequestController
 * @var $model VisitGuest
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Visit Request'=>array('manage'),
		'Headline',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'visit-guest-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<div class="dialog-content">
		<?php echo Phrase::trans(339,0);?>	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton(Phrase::trans(338,0), array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Phrase::trans(174,0), array('id'=>'closed')); ?>
	</div>
	
<?php $this->endWidget(); ?>
