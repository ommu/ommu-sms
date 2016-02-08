<?php
/**
 * Book Reviews (book-reviews)
 * @var $this ReviewController * @var $model BookReviews *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Book Reviews'=>array('manage'),
		$model->review_id,
	);

	if($model->book_relation->cover != '')
		$images = Yii::app()->request->baseUrl.'/public/book/book/'.$model->book_relation->cover;
	else
		$images = Yii::app()->request->baseUrl.'/public/article/article_default.png';
?>

<div class="meta-date clearfix">
	<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($model->published_date, true);?></span>
	<span class="by"><i class="fa fa-user"></i>&nbsp;<?php echo $model->resensator_id != 0 ? ucwords($model->resensator_relation->name) : ucwords($model->creation_relation->displayname);?></span>
	<span class="view"><i class="fa fa-eye"></i>&nbsp;<?php echo $model->view;?></span>
</div>

<div class="box-content clearfix">
	<img class="headline" src="<?php echo Utility::getTimThumb($images, 240, 350, 1);?>" alt="<?php echo $model->book_relation->title;?>" />		
	<?php echo $model->body;?>
</div>
