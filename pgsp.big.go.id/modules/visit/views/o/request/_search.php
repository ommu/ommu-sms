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
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('guest_id'); ?><br/>
			<?php echo $form->textField($model,'guest_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('status'); ?><br/>
			<?php echo $form->textField($model,'status'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('start_date'); ?><br/>
			<?php echo $form->textField($model,'start_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('finish_date'); ?><br/>
			<?php echo $form->textField($model,'finish_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('organization'); ?><br/>
			<?php echo $form->textField($model,'organization'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('organization_name'); ?><br/>
			<?php echo $form->textField($model,'organization_name',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('organization_address'); ?><br/>
			<?php echo $form->textArea($model,'organization_address',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('organization_phone'); ?><br/>
			<?php echo $form->textField($model,'organization_phone',array('size'=>15,'maxlength'=>15)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('visitor'); ?><br/>
			<?php echo $form->textField($model,'visitor'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('messages'); ?><br/>
			<?php echo $form->textArea($model,'messages',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_file'); ?><br/>
			<?php echo $form->textArea($model,'message_file',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('message_reply'); ?><br/>
			<?php echo $form->textArea($model,'message_reply',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
