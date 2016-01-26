<?php
/**
 * Visits (visits)
 * @var $this AdminController
 * @var $model Visits
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:00 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'visits-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">
	<fieldset>
		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'guest_id'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'guest_id',array('size'=>11,'maxlength'=>11)); ?>
				<?php echo $form->error($model,'guest_id'); ?>
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
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'status'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'status'); ?>
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>
		</div>

	</fieldset>

</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>