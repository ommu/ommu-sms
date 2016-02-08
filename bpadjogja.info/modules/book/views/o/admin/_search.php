<?php
/**
 * Book Masters (book-masters)
 * @var $this AdminController * @var $model BookMasters * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
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
			<?php echo $model->getAttributeLabel('book_id'); ?><br/>
			<?php echo $form->textField($model,'book_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publisher_id'); ?><br/>
			<?php echo $form->textField($model,'publisher_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('isbn'); ?><br/>
			<?php echo $form->textField($model,'isbn',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('title'); ?><br/>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('description'); ?><br/>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('cover'); ?><br/>
			<?php echo $form->textField($model,'cover',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('edition'); ?><br/>
			<?php echo $form->textField($model,'edition',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish_year'); ?><br/>
			<?php echo $form->textField($model,'publish_year',array('size'=>4,'maxlength'=>4)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('paging'); ?><br/>
			<?php echo $form->textField($model,'paging',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('sizes'); ?><br/>
			<?php echo $form->textField($model,'sizes',array('size'=>60,'maxlength'=>64)); ?>
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
