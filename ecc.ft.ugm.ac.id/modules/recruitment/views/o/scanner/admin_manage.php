<?php
/**
 * Recruitments (recruitments)
 * @var $this ScannerController
 * @var $model Recruitments
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 March 2016, 23:23 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitments'=>array('manage'),
		'Manage',
	);
	$cs = Yii::app()->getClientScript();
	$cs->registerCssFile(Yii::app()->request->baseUrl.'/externals/recruitment/recruitment.css');
	$cs->registerScriptFile(Yii::app()->request->baseUrl.'/externals/recruitment/custom.js', CClientScript::POS_END);
	
?>

<?php if(!Yii::app()->request->isAjaxRequest) {?>
	<div class="search-input">
		<div class="barcode">
			<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
				'id'=>'book-grants-form',
				'enableAjaxValidation'=>true,
				'htmlOptions' => array(
					'enctype' => 'multipart/form-data',
				),
			)); ?>
				<input type="text" name="barcodeField" placeholder="Input: Barcode Number" autofocus="autofocus">
				<?php /*<input type="submit" value="Search">*/?>
			<?php $this->endWidget(); ?>		
		</div>
		<div class="testnumber">
			<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
				'id'=>'book-grants-form',
				'enableAjaxValidation'=>true,
				'htmlOptions' => array(
					'enctype' => 'multipart/form-data',
				),
			)); ?>		
				<input type="text" name="testnumberField" placeholder="Input: Test Number">
				<?php /*<input type="submit" value="Search">*/?>
			<?php $this->endWidget(); ?>		
		</div>
	</div>

	<div class="search-result">
		<div id="loading"></div>
		<div id="result">
			<?php if($user != null || $eventUser != null || $sessionActive != null) {
				echo $this->renderPartial('_view_user', array(
					'user'=>$user,
					'eventUser'=>$eventUser,
					'sessionActive'=>$sessionActive,
				));
			}?>
			<?php if($event != null)
				echo $this->renderPartial('_view_event', array('event'=>$event)); ?>
		</div>
	</div>
	
<?php } else {
	if($user != null || $eventUser != null || $sessionActive != null) {
		echo $this->renderPartial('_view_user', array(
			'user'=>$user,
			'eventUser'=>$eventUser,
			'sessionActive'=>$sessionActive,
		));
	}
	if($event != null)
		echo $this->renderPartial('_view_event', array('event'=>$event));
}?>