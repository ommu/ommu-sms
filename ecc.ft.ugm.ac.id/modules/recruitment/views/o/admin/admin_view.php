<?php
/**
 * Recruitments (recruitments)
 * @var $this AdminController
 * @var $model Recruitments
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:52 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitments'=>array('manage'),
		$model->recruitment_id,
	);
?>

<div class="dialog-content">
<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'recruitment_id',
			'value'=>$model->recruitment_id,
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			'type'=>'raw',
		),
		array(
			'name'=>'event_name',
			'value'=>$model->event_name,
		),
		array(
			'name'=>'event_desc',
			'value'=>$model->event_desc != '' ? $model->event_desc : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'event_type',
			'value'=>$model->event_type == 0 ? 'Direct' : 'Bundle',
		),
		array(
			'name'=>'start_date',
			'value'=>!in_array($model->start_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->start_date) : '-',
		),
		array(
			'name'=>'finish_date',
			'value'=>!in_array($model->finish_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->finish_date) : '-',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id != 0 ? $model->creation->displayname : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id != 0 ? $model->modified->displayname : '-',
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
