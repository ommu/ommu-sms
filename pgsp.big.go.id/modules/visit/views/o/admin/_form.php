<?php
/**
 * Visits (visits)
 * @var $this SiteController
 * @var $model Visits
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
	'id'=>'visits-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>
	<?php if($model->isNewRecord) {?>
		<div class="clearfix">
			<?php echo $form->labelEx($author,'name'); ?>
			<div class="desc">
				<?php echo $form->textField($author,'name',array('maxlength'=>32,'class'=>'span-4')); ?>
				<?php echo $form->error($author,'name'); ?>
			</div>
		</div>
		
		<div class="clearfix">
			<?php echo $form->labelEx($author,'email'); ?>
			<div class="desc">
				<?php echo $form->textField($author,'email',array('maxlength'=>32,'class'=>'span-4')); ?>
				<?php echo $form->error($author,'email'); ?>
			</div>
		</div>
		
		<div class="clearfix">
			<?php echo $form->labelEx($author,'author_phone'); ?>
			<div class="desc">
				<?php echo $form->textField($author,'author_phone',array('maxlength'=>15,'class'=>'span-4')); ?>
				<?php echo $form->error($author,'author_phone'); ?>
			</div>
		</div>			
	<?php }?>
	
	<div class="clearfix publish">
		<?php echo $form->labelEx($guest,'organization'); ?>
		<div class="desc">
			<?php 
			echo $form->radioButtonList($guest,'organization', array(
				1 => 'Organization',
				0 => 'Personal',
			)); ?>
			<?php echo $form->error($guest,'organization'); ?>
		</div>
	</div>
	
	<div id="organization" <?php echo $guest->organization != 1 ? 'class="hide"' : ''; ?>>
		<div class="clearfix">
			<label><?php echo $guest->getAttributeLabel('organization_name')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($guest,'organization_name',array('maxlength'=>64,'class'=>'span-6')); ?>
				<?php echo $form->error($guest,'organization_name'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $guest->getAttributeLabel('organization_address')?> <span class="required">*</span></label>
			<div class="desc">
				<?php 
				//echo $form->textArea($guest,'organization_address',array('rows'=>6, 'cols'=>50));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$guest,
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
				<?php echo $form->error($guest,'organization_address'); ?>
			</div>
		</div>

		<div class="clearfix">
			<label><?php echo $guest->getAttributeLabel('organization_phone')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->textField($guest,'organization_phone',array('maxlength'=>15,'class'=>'span-4')); ?>
				<?php echo $form->error($guest,'organization_phone'); ?>
			</div>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($guest,'visitor'); ?>
		<div class="desc">
			<?php echo $form->textField($guest,'visitor',array('maxlength'=>3,'class'=>'span-2')); ?>
			<?php echo $form->error($guest,'visitor'); ?>
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
					'class' => 'span-4',
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
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'finish_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>
	
	<div class="clearfix">
		<label><?php echo $guest->getAttributeLabel('status')?> <span class="required">*</span></label>
		<div class="desc">
			<?php echo $form->dropDownList($guest,'status', array(
				'0'=>'Pending',
				'1'=>'Approved (Add to Schedule)',
				'2'=>'Rejected',
			), array('prompt'=>'')); ?>
			<?php echo $form->error($guest,'status'); ?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($guest,'messages'); ?>
		<div class="desc">
			<?php 
			//echo $form->textArea($guest,'messages',array('rows'=>6, 'cols'=>50));
			$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
				'model'=>$guest,
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
			<?php echo $form->error($guest,'messages'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>
	
	<?php
	if(!$model->isNewRecord) {
		$guest->old_file = $guest->message_file;
		echo $form->hiddenField($guest,'old_file');
		if($guest->message_file != '') {
			$file = Yii::app()->request->baseUrl.'/public/visit/'.$guest->message_file;
			echo '<div class="clearfix">';
			echo $form->labelEx($guest,'old_file');
			echo '<div class="desc"><a href="'.$file.'" title="'.$guest->message_file.'">'.$guest->message_file.'</a></div>';
			echo '</div>';
		}
	}?>

	<div class="clearfix">
		<?php echo $form->labelEx($guest,'message_file'); ?>
		<div class="desc">
			<?php echo $form->fileField($guest,'message_file'); ?>
			<?php echo $form->error($guest,'message_file'); ?>
		</div>
	</div>
		
	<div class="clearfix">
		<?php echo $form->labelEx($guest,'message_reply'); ?>
		<div class="desc">
			<?php 
			//echo $form->textArea($guest,'message_reply',array('rows'=>6, 'cols'=>50));
			$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
				'model'=>$guest,
				'attribute'=>message_reply,
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
			<?php echo $form->error($guest,'message_reply'); ?>
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


