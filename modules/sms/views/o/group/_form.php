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

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'articles-form',
	'enableAjaxValidation'=>$validation,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'group_name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'group_name',array('maxlength'=>32)); ?>
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
		
		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'contact_input'); ?>
			<div class="desc">
				<?php 
				//echo $form->textField($model,'contact_input',array('maxlength'=>32, 'class'=>'span-5'));
				$url = Yii::app()->controller->createUrl('o/groupbook/add', array('type'=>'sms'));
				$group = $model->group_id;
				$contactId = 'SmsGroups_contact_input';
				$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'contact_input',
					'source' => Yii::app()->controller->createUrl('o/phonebook/suggest', array('group'=>$model->group_id)),
					'options' => array(
						//'delay '=> 50,
						'minLength' => 1,
						'showAnim' => 'fold',
						'select' => "js:function(event, ui) {
							$.ajax({
								type: 'post',
								url: '$url',
								data: { group_id: '$group', phonebook_id: ui.item.id},
								dataType: 'json',
								success: function(response) {
									$('form #$contactId').val('');
									$('form #phonebook-suggest').append(response.data);
								}
							});

						}"
					),
					'htmlOptions' => array(
						'class'	=> 'span-5',
					),
				));
				echo $form->error($model,'contact_input'); ?>
				<div id="phonebook-suggest" class="suggest clearfix">
					<?php 
					if($phonebook != null) {
						foreach($phonebook as $key => $val) {
						$contact = $val->phonebook_TO->phonebook_name != '' ? $val->phonebook_TO->phonebook_name : $val->phonebook_TO->phonebook_nomor; ?>
						<div><?php echo $contact;?><a href="<?php echo Yii::app()->controller->createUrl('o/groupbook/delete',array('id'=>$val->id,'type'=>'sms'));?>" title="<?php echo Yii::t('phrase', 'Delete');?>"><?php echo Yii::t('phrase', 'Delete');?></a></div>
					<?php }
					}?>
				</div>
			</div>
		</div>
		
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

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'status'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'status'); ?>
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->error($model,'status'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="submit clearfix">
			<label>&nbsp;</label>
			<div class="desc">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save')) ,array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
<?php $this->endWidget(); ?>

