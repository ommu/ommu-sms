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
	)
)); ?>
<div class="dialog-content">
	<fieldset>
		<div class="clearfix">
			<label>Excel <span class="required">*</span></label>
			<div class="desc">
				<input type="file" name="phonebookExcel">
				<?php if(Yii::app()->user->hasFlash('error')) {
					echo '<div class="errorMessage">'.Yii::app()->user->getFlash('error').'</div>';
				}?>
				<div class="pt-10">Download: <a off_address="" target="_blank" href="<?php echo Yii::app()->request->baseUrl;?>/externals/sms/sms_phonebook_import.xls" title="Template Import">Template Import</a></div>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton('Import Contact' ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
