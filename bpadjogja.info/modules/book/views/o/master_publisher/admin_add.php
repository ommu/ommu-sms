<?php
/**
 * Book Master Publishers (book-master-publishers)
 * @var $this MasterpublisherController * @var $model BookMasterPublishers *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Master Publishers'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('/o/master_publisher/_form', array('model'=>$model)); ?>