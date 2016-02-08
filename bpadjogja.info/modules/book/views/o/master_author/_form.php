<?php
/**
 * Book Master Authors (book-master-authors)
 * @var $this MasterauthorController * @var $model BookMasterAuthors * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'book-master-authors-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>

<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php //echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>
	
		<?php if(!$model->isNewRecord && $model->author_photo != '') {?>
		<div class="clearfix">
			<?php echo $form->labelEx($model,'old_photo'); ?>
			<div class="desc">
				<?php 
				$model->old_photo = $model->author_photo;
				echo $form->hiddenField($model,'old_photo');
				$media = Yii::app()->request->baseUrl.'/public/book/author/'.$model->old_photo;
				?>
				<img src="<?php echo Utility::getTimThumb($media, 200, 300, 3);?>" alt="">
			</div>
		</div>
		<?php }?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'author_photo'); ?>
			<div class="desc">
				<?php echo $form->fileField($model,'author_photo',array('maxlength'=>64,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'author_photo'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'author_name'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'author_name',array('maxlength'=>64,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'author_name'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'website'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'website',array('maxlength'=>128,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'website'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'wikipedia'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'wikipedia',array('maxlength'=>128,'class'=>'span-8')); ?>
				<?php echo $form->error($model,'wikipedia'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'publish'); ?>
			<div class="desc">
				<?php echo $form->checkBox($model,'publish'); ?>
				<?php echo $form->labelEx($model,'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
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


