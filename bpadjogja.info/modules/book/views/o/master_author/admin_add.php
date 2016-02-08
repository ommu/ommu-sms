<?php
/**
 * Book Master Authors (book-master-authors)
 * @var $this MasterauthorController * @var $model BookMasterAuthors *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Master Authors'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('/o/master_author/_form', array('model'=>$model)); ?>