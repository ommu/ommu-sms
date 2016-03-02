<?php
/**
 * Recruitment Settings (recruitment-setting)
 * @var $this SettingController
 * @var $model RecruitmentSetting
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:53 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'recruitment-setting-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<label>
			<?php echo $model->getAttributeLabel('license');?> <span class="required">*</span><br/>
			<span>Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please contact support team.</span>
		</label>
		<div class="desc">
			<?php echo $form->textField($model,'license',array('maxlength'=>32,'class'=>'span-4','disabled'=>'disabled')); ?>
			<?php echo $form->error($model,'license'); ?>
			<span class="small-px">Format: XXXX-XXXX-XXXX-XXXX</span>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'permission'); ?>
		<div class="desc">
			<span class="small-px">Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the General Settings page.</span>
			<?php echo $form->radioButtonList($model, 'permission', array(
				1 => 'Yes, the public can view recruitment unless they are made private.',
				0 => 'No, the public cannot view recruitments.',
			)); ?>
			<?php echo $form->error($model,'permission'); ?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'meta_keyword'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'meta_keyword',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
			<?php echo $form->error($model,'meta_keyword'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'meta_description'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span-7 smaller')); ?>
			<?php echo $form->error($model,'meta_description'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>


