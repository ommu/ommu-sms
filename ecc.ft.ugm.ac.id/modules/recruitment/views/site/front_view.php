<?php
/**
 * Recruitments (recruitments)
 * @var $this SiteController
 * @var $model Recruitments
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 11 March 2016, 10:27 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitments'=>array('manage'),
		$model->recruitment_id,
	);
	
	if($model->event_logo != '')
		$images = Yii::app()->request->baseUrl.'/public/recruitment/'.$model->event_logo;
	else
		$images = Yii::app()->request->baseUrl.'/public/recruitment/recruitment_default.png';
?>

<?php echo $model->event_name != $model->event_desc ? '<p>'.$model->event_desc.'</p>' : ''?>

<div class="event-info">
	<div class="event-photo">
		<img src="<?php echo Utility::getTimThumb($images, 200, 200, 2);?>" alt="<?php echo $model->event_name;?>">
	</div>
	<div class="event-statistic">
		<ul class="clearfix">
			<li>
				<span><?php echo $model->view->sessions;?></span>
				<strong>Sessions</strong>
			</li>
			<li>
				<span><?php echo $model->view->batchs;?></span>
				<strong>Batchs</strong>
			</li>
			<li>
				<span><?php echo $model->view->users;?></span>
				<strong>Users</strong>
			</li>
		</ul>
	</div>
</div>

<?php if($session != null) {?>
<div class="sessions">
	<?php 
	$i = 0;
	foreach($session as $key => $val) {
		$i++;?>
		
		<div class="sep <?php echo !in_array($val->session_date, array('0000-00-00','1970-01-01')) ? (date('Y-m-d', strtotime($val->session_date)) == date('Y-m-d') ? 'active' : (date('Y-m-d', strtotime($val->session_date)) < date('Y-m-d') ? 'done' : '')) : ''?>">
			<h3>
				<strong><?php echo $i;?></strong>
				<?php echo $val->session_name;?>
				<span>(<?php echo $val->session_code != '' ? $val->session_code.'/ ' : ''?><?php echo !in_array($val->session_date, array('0000-00-00','1970-01-01')) ? Utility::dateFormat($val->session_date).'/ ' : '';?> <?php echo $val->view->batchs;?> Batchs/ <?php echo $val->view->users;?> Users)</span>
			</h3>
		</div>
	<?php }?>
</div>
<?php }?>