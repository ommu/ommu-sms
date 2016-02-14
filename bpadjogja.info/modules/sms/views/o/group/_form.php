<?php
/**
 * Sms Groups (sms-groups)
 * @var $this GroupController
 * @var $model SmsGroups
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 18:27 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
	
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#SmsGroups_import_excel').live('change', function() {
		var id = $(this).prop('checked');		
		if(id == true) {
			$('div#import').slideDown();
		} else {
			$('div#import').slideUp();
		}
	});
EOP;
	$cs->registerScript('setting', $js, CClientScript::POS_END);
?>

<?php 
if($model->isNewRecord) {
	$form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'sms-groups-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));	
} else {
	$form=$this->beginWidget('application.components.system.OActiveForm', array(
		'id'=>'sms-groups-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array(
			'on_post' => 'on_post',
			'enctype' => 'multipart/form-data',
		),
	));	
} ?>
<div class="dialog-content">

	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'group_name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'group_name',array('size'=>32,'maxlength'=>32)); ?>
				<?php echo $form->error($model,'group_name'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'group_desc'); ?>
			<div class="desc">
				<?php echo $form->textArea($model,'group_desc',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'group_desc'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		
		<?php if(!$model->isNewRecord) {?>
			<div class="clearfix publish">
				<?php echo $form->labelEx($model,'import_excel'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'import_excel'); ?>
					<?php echo $form->labelEx($model,'import_excel'); ?>
					<?php echo $form->error($model,'import_excel'); ?>
				</div>
			</div>

			<div id="import" class="clearfix <?php echo $model->import_excel == 0 ? 'hide' : ''?>">
				<?php echo $form->labelEx($model,'groupbookExcel'); ?>
				<div class="desc">
					<?php echo $form->fileField($model,'groupbookExcel'); ?>
					<div class="pt-10">Download: <a off_address="" target="_blank" href="<?php echo Yii::app()->request->baseUrl;?>/externals/sms/sms_groupbook_import.xls" title="Template Import Groupbook">Template Import Groupbook</a></div>
					<?php echo $form->error($model,'groupbookExcel'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
		<?php }?>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'status'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'status'); ?>
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->error($model,'status'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


