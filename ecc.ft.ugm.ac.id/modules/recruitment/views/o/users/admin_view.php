<?php
/**
 * Recruitment Users (recruitment-users)
 * @var $this UsersController
 * @var $model RecruitmentUsers
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:54 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitment Users'=>array('manage'),
		$model->user_id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'user_id',
			'value'=>$model->user_id,
			//'value'=>$model->user_id != '' ? $model->user_id : '-',
		),
		array(
			'name'=>'enabled',
			'value'=>$model->enabled,
			//'value'=>$model->enabled != '' ? $model->enabled : '-',
		),
		array(
			'name'=>'salt',
			'value'=>$model->salt,
			//'value'=>$model->salt != '' ? $model->salt : '-',
		),
		array(
			'name'=>'email',
			'value'=>$model->email,
			//'value'=>$model->email != '' ? $model->email : '-',
		),
		array(
			'name'=>'username',
			'value'=>$model->username,
			//'value'=>$model->username != '' ? $model->username : '-',
		),
		array(
			'name'=>'password',
			'value'=>$model->password,
			//'value'=>$model->password != '' ? $model->password : '-',
		),
		array(
			'name'=>'displayname',
			'value'=>$model->displayname,
			//'value'=>$model->displayname != '' ? $model->displayname : '-',
		),
		array(
			'name'=>'photos',
			'value'=>'value'=>$model->photos != '' ? $model->photos : '-',
			//'value'=>$model->photos != '' ? CHtml::link($model->photos, Yii::app()->request->baseUrl.'/public/visit/'.$model->photos, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'creation_date',
			'value'=>Utility::dateFormat($model->creation_date, true),
		),
		array(
			'name'=>'creation_ip',
			'value'=>$model->creation_ip,
			//'value'=>$model->creation_ip != '' ? $model->creation_ip : '-',
		),
		array(
			'name'=>'update_date',
			'value'=>Utility::dateFormat($model->update_date, true),
		),
		array(
			'name'=>'update_ip',
			'value'=>$model->update_ip,
			//'value'=>$model->update_ip != '' ? $model->update_ip : '-',
		),
		array(
			'name'=>'lastlogin_date',
			'value'=>Utility::dateFormat($model->lastlogin_date, true),
		),
		array(
			'name'=>'lastlogin_ip',
			'value'=>$model->lastlogin_ip,
			//'value'=>$model->lastlogin_ip != '' ? $model->lastlogin_ip : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>Utility::dateFormat($model->modified_date, true),
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id,
			//'value'=>$model->modified_id != '' ? $model->modified_id : '-',
		),
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
