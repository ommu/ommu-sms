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

	$this->breadcrumbs=array(
		'Visit Request'=>array('manage'),
		$model->guest_id=>array('view','id'=>$model->guest_id),
		'Update',
	);
?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'start_date',
			'value'=>Utility::dateFormat($model->start_date),
		),
		array(
			'name'=>'finish_date',
			'value'=>Utility::dateFormat($model->finish_date),
		),
		'visitor',
		array(
			'name'=>'Visit Type',
			'value'=>$model->organization == 1 ? 'Organisasi' : 'Personal',
		),
		array(
			'name'=>'organization_name',
			'value'=>$model->organization_name,
		),
		array(
			'name'=>'organization_address',
			'value'=>$model->organization_address != '' ? $model->organization_address : '-',
			'type'=>'raw',
		),
		'organization_phone',
		array(
			'name'=>'PIC Name',
			'value'=>$model->author_TO->name,
		),
		array(
			'name'=>'PIC Email',
			'value'=>$model->author_TO->email,
		),
		array(
			'name'=>'messages',
			'value'=>$model->messages,
			'type'=>'raw',
		),
		array(
			'name'=>'message_file',
			'value'=>$model->message_file != '' ? CHtml::link($model->message_file, Yii::app()->request->baseUrl.'/public/visit/'.$model->message_file, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_TO->displayname,
		),
		array(
			'name'=>'modified_date',
			'value'=>Utility::dateFormat($model->modified_date, true),
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id != 0 ? $model->modified_TO->displayname : '-',
		),
	),
)); ?>

<div class="form" style="margin-top: 15px;">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'schedule'=>$schedule,
	)); ?>
</div>
