<?php
/**
 * Book Requests (book-requests)
 * @var $this RequestController * @var $model BookRequests * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Requests',
	);
?>

<div class="form" name="post-on">
	<?php echo $this->renderPartial('_form', array(
		'model'=>$model,
		'book'=>$book,
		'author'=>$author,
	)); ?>
</div>

<div class="box">
	<div class="title clearfix">
		<h2>Daftar Usulan Buku</h2>
	</div>
	<?php $this->widget('application.components.system.FListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'pager' => array(
			'header' => '',
		), 
		'summaryText' => '',
		'itemsCssClass' => 'items clearfix',
		'pagerCssClass'=>'pager clearfix',
	)); ?>
</div>