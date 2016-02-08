<?php
/**
 * Book Masters (book-masters)
 * @var $this AdminController * @var $model BookMasters *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Masters'=>array('manage'),
		$model->title,
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
		'book_id',
		'publish',
		'publisher_id',
		'isbn',
		'title',
		'description',
		'cover',
		'edition',
		'publish_year',
		'paging',
		'sizes',
		'creation_date',
		'creation_id',
		'modified_date',
		'modified_id',
	),
)); ?>

<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
