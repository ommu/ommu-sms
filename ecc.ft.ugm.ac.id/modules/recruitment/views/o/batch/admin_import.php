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

	$this->breadcrumbs=array(
		'Visits'=>array('manage'),
		'Upload',
	);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'book-grants-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	),
)); ?>
<div class="dialog-content">
	<fieldset>
		<?php if($sessionsFieldRender == false) {?>
			<div class="clearfix">
				<label>Recruitment Sessions <span class="required">*</span></label>
				<div class="desc">
					<?php if(RecruitmentSessions::getSession('batch') != null)
						echo CHtml::dropDownList('sessionsId', $select, RecruitmentSessions::getSession('batch'), array('empty' => 'Pilih batch session'));
					else						
						echo CHtml::dropDownList('sessionsId', $select, array('empty' => 'Pilih batch session')); ?>
					<?php if(Yii::app()->user->hasFlash('errorSession')) {
						echo '<div class="errorMessage">'.Yii::app()->user->getFlash('errorSession').'</div>';
					}?>
				</div>
			</div>
		<?php }?>
		
		<div class="clearfix">
			<label>Excel <span class="required">*</span></label>
			<div class="desc">
				<input type="file" name="usersExcel">
				<?php if(Yii::app()->user->hasFlash('errorFile')) {
					echo '<div class="errorMessage">'.Yii::app()->user->getFlash('errorFile').'</div>';
				}?>
				<div class="pt-10"><a off_address="" target="_blank" class="template" href="<?php echo Yii::app()->request->baseUrl;?>/externals/recruitment/session_user_bundle.xls" title="User Bundle Template">User Bundle Template</a> <a off_address="" target="_blank" class="template" href="<?php echo Yii::app()->request->baseUrl;?>/externals/recruitment/session_user_direct.xls" title="User Direct Template">User Direct Template</a></div>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton('Import Users' ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
