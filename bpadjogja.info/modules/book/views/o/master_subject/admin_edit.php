<?php
/**
 * Book Master Subjects (book-master-subjects)
 * @var $this MastersubjectController * @var $model BookMasterSubjects *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Master Subjects'=>array('manage'),
		$model->subject_id=>array('view','id'=>$model->subject_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('/o/master_subject/_form', array('model'=>$model)); ?>
