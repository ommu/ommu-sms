<?php
/**
 * Recruitment Sessions (recruitment-sessions)
 * @var $this BatchController
 * @var $batch RecruitmentSessions
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 8 March 2016, 12:04 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitment Sessions'=>array('manage'),
		'Create',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'recruitment-sessions-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		//'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>
<div class="dialog-content">

	<fieldset>
		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php //echo $form->errorSummary($session); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($session,'blasting_subject'); ?>
			<div class="desc">
				<?php echo $form->textField($session,'blasting_subject', array('maxlength'=>64, 'class'=>'span-9')); ?>
				<?php echo $form->error($session,'blasting_subject'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($session->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


