<?php
/**
 * Recruitment Sessions (recruitment-sessions)
 * @var $this BatchController
 * @var $model RecruitmentSessions
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 8 March 2016, 12:04 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitment Sessions'=>array('manage'),
		$model->session_id,
	);
?>

<div class="dialog-content">
	<?php $this->widget('application.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'session_id',
				'value'=>$model->session_id,
				//'value'=>$model->session_id != '' ? $model->session_id : '-',
			),
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : Chtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				//'value'=>$model->publish,
			),
			array(
				'name'=>'recruitment_id',
				'value'=>$model->recruitment_id,
				//'value'=>$model->recruitment_id != '' ? $model->recruitment_id : '-',
			),
			array(
				'name'=>'parent_id',
				'value'=>$model->parent_id,
				//'value'=>$model->parent_id != '' ? $model->parent_id : '-',
			),
			array(
				'name'=>'session_name',
				'value'=>$model->session_name,
				//'value'=>$model->session_name != '' ? $model->session_name : '-',
			),
			array(
				'name'=>'session_info',
				'value'=>$model->session_info != '' ? $model->session_info : '-',
				//'value'=>$model->session_info != '' ? CHtml::link($model->session_info, Yii::app()->request->baseUrl.'/public/visit/'.$model->session_info, array('target' => '_blank')) : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'session_date',
				'value'=>!in_array($model->session_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($model->session_date) : '-',
			),
			array(
				'name'=>'session_time_start',
				'value'=>$model->session_time_start,
				//'value'=>$model->session_time_start != '' ? $model->session_time_start : '-',
			),
			array(
				'name'=>'session_time_finish',
				'value'=>$model->session_time_finish,
				//'value'=>$model->session_time_finish != '' ? $model->session_time_finish : '-',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation_id,
				//'value'=>$model->creation_id != 0 ? $model->creation_id : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified_id,
				//'value'=>$model->modified_id != 0 ? $model->modified_id : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
