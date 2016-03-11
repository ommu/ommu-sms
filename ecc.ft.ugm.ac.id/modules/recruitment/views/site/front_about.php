<?php
/**
 * @var $this SiteController
 * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 */
?>

<?php if($news->media_show == 1) {
	$images = Yii::app()->request->baseUrl.'/public/page/'.$news->media;
	if($this->adsSidebar == true) {
		if($news->media_type == 1)
			echo '<img class="largemag" src="'.Utility::getTimThumb($images, 600, 900, 3).'" alt="">';
		else
			echo '<img class="mediummag" src="'.Utility::getTimThumb($images, 270, 500, 3).'" alt="">';
	} else {
		if($news->media_type == 1)
			echo '<img class="largemag" src="'.Utility::getTimThumb($images, 1280, 1024, 3).'" alt="">';
		else
			echo '<img class="mediummag" src="'.Utility::getTimThumb($images, 270, 500, 3).'" alt="">';
	}
}?>

<?php echo Phrase::trans($news->name, 2) != Utility::hardDecode(Phrase::trans($news->desc, 2)) ? Utility::cleanImageContent(Phrase::trans($news->desc, 2)) : '';?>