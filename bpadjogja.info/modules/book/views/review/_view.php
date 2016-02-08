<?php
/**
 * Book Reviews (book-reviews)
 * @var $this ReviewController * @var $data BookReviews *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	if($data->book_relation->cover != '')
		$images = Yii::app()->request->baseUrl.'/public/book/book/'.$data->book_relation->cover;
	else
		$images = Yii::app()->request->baseUrl.'/public/article/article_default.png';
?>

<div class="sep">
	<a class="images" href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->review_id,'t'=>Utility::getUrlTitle($data->book_relation->title)));?>" title="<?php echo $data->book_relation->title;?>">
		<img src="<?php echo Utility::getTimThumb($images, 300, 150, 1);?>" alt="<?php echo $data->book_relation->title;?>" />
	</a>
	<a class="title" href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->review_id,'t'=>Utility::getUrlTitle($data->book_relation->title)));?>" title="<?php echo $data->book_relation->title;?>"><?php echo Utility::shortText(Utility::hardDecode($data->book_relation->title),40);?></a>
	<div class="meta-date clearfix">
		<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($data->published_date, true);?></span>
		<span class="view"><i class="fa fa-eye"></i>&nbsp;<?php echo $data->view;?></span>
	</div>
	<p><?php echo Utility::shortText(Utility::hardDecode($data->body),100);?></p>
</div>