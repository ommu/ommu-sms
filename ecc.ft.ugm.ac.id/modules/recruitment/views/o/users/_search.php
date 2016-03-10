<?php
/**
 * Recruitment Users (recruitment-users)
 * @var $this UsersController
 * @var $model RecruitmentUsers
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:54 WIB
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
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('enabled'); ?><br/>
			<?php echo $form->textField($model,'enabled'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('salt'); ?><br/>
			<?php echo $form->textField($model,'salt',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('email'); ?><br/>
			<?php echo $form->textField($model,'email',array('size'=>32,'maxlength'=>32)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('displayname'); ?><br/>
			<?php echo $form->textField($model,'displayname',array('size'=>60,'maxlength'=>64)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('photos'); ?><br/>
			<?php echo $form->textArea($model,'photos',array('rows'=>6, 'cols'=>50)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_ip'); ?><br/>
			<?php echo $form->textField($model,'creation_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('update_date'); ?><br/>
			<?php echo $form->textField($model,'update_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('update_ip'); ?><br/>
			<?php echo $form->textField($model,'update_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('lastlogin_date'); ?><br/>
			<?php echo $form->textField($model,'lastlogin_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('lastlogin_ip'); ?><br/>
			<?php echo $form->textField($model,'lastlogin_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Phrase::trans(3,0)); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
