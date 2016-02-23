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
	$action = strtolower(Yii::app()->controller->action->id);
	
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#VisitGuest_organization input[name="VisitGuest[organization]"]').live('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#organization').slideUp();
		} else {
			$('div#organization').slideDown();
		}
	});
EOP;
	$cs->registerScript('setting', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'visit-guest-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($author,'name'); ?>
		<div class="desc">
			<?php echo $form->textField($author,'name',array('maxlength'=>32,'class'=>'span-6')); ?>
			<?php echo $form->error($author,'name'); ?>
		</div>
	</div>
	
	<div class="clearfix">
		<?php echo $form->labelEx($author,'email'); ?>
		<div class="desc">
			<?php echo $form->textField($author,'email',array('maxlength'=>32,'class'=>'span-6')); ?>
			<?php echo $form->error($author,'email'); ?>
		</div>
	</div>
	
	<div class="clearfix">
		<?php echo $form->labelEx($author,'author_phone'); ?>
		<div class="desc">
			<?php echo $form->textField($author,'author_phone',array('maxlength'=>15,'class'=>'span-6')); ?>
			<?php echo $form->error($author,'author_phone'); ?>
		</div>
	</div>

	<div class="clearfix publish">
		<label>Tipe Kunjungan <span class="required">*</span></label>
		<div class="desc">
			<?php 
			echo $form->radioButtonList($model,'organization', array(
				1 => 'Organisasi',
				0 => 'Pribadi',
			)); ?>
			<?php echo $form->error($model,'organization'); ?>
		</div>
	</div>
	
	<div id="organization" <?php echo $model->organization != 1 ? 'class="hide"' : ''; ?>>
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('organization_name')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'organization_name',array('maxlength'=>64,'class'=>'span-7')); ?>
				<?php echo $form->error($model,'organization_name'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('organization_address')?> <span class="required">*</span></label>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'organization_address',array('rows'=>6, 'cols'=>50));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>organization_address,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', '|', 
							'bold', 'italic', '|',
						),
					),
					'plugins' => array(
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
				)); ?>
				<?php echo $form->error($model,'organization_address'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('organization_phone')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($model,'organization_phone',array('maxlength'=>15,'class'=>'span-6')); ?>
				<?php echo $form->error($model,'organization_phone'); ?>
			</div>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'visitor'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'visitor',array('maxlength'=>3,'class'=>'span-3')); ?>
			<?php echo $form->error($model,'visitor'); ?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->start_date != '0000-00-00' ? $model->start_date = date('d-m-Y', strtotime($model->start_date)) : '') : '';
			//echo $form->textField($model,'start_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'start_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-5',
				 ),
			)); ?>
			<?php echo $form->error($model,'start_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'finish_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->finish_date != '0000-00-00' ? $model->finish_date = date('d-m-Y', strtotime($model->finish_date)) : '') : '';
			//echo $form->textField($model,'finish_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'finish_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-5',
				 ),
			)); ?>
			<?php echo $form->error($model,'finish_date'); ?>
			<div class="small-px silent mt-10">Keterangan: tanggal selesai boleh sama dengan tanggal mulai</div>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'messages'); ?>
		<div class="desc">
			<?php 
			//echo $form->textArea($model,'messages',array('rows'=>6, 'cols'=>50));
			$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
				'model'=>$model,
				'attribute'=>messages,
				// Redactor options
				'options'=>array(
					//'lang'=>'fi',
					'buttons'=>array(
						'html', 'formatting', '|', 
						'bold', 'italic', 'deleted', '|',
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
						'link', '|',
					),
				),
				'plugins' => array(
					'fontcolor' => array('js' => array('fontcolor.js')),
					'fullscreen' => array('js' => array('fullscreen.js')),
				),
			)); ?>
			<?php echo $form->error($model,'messages'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'message_file'); ?>
		<div class="desc">
			<?php echo $form->fileField($model,'message_file'); ?>
			<?php echo $form->error($model,'message_file'); ?>
			<div class="small-px silent mt-10">File: bmp, gif, jpg, jpeg, png, pdf, doc, opt, docx, ppt, pptx, zip, rar, 7z</div>
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


