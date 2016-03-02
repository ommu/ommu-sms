<?php
/**
 * Recruitment Session Users (recruitment-session-user)
 * @var $this SessionuserController
 * @var $model RecruitmentSessionUser
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:53 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitment Session Users'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('/o/session_user/_form', array('model'=>$model)); ?>