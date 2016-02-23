<?php
/**
 * Visits (visits)
 * @var $this SiteController
 * @var $model Visits
 * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Visits',
	);
?>

<div class="table">
	<div class="cell">
		<?php echo $cal->generate();?>
	</div>
	<div class="cell">
	<div class="agenda">
		<?php if($model != null) {
			foreach($model as $key => $val) {?>
				<div class="sep">
					<div class="date"><?php echo $val->start_date == $val->finish_date ? $val->start_date : $val->start_date.' s/d '.$val->finish_date;?></div>
					<?php echo $val->guest_TO->organization == 1 ? ($val->guest_TO->author_id != 0 ? $val->guest_TO->organization_name." (".$val->guest_TO->author_TO->name.")" : $val->guest_TO->organization_name) : $val->guest_TO->author_TO->name;?>
				</div>
		<?php }
		}?>
	</div>
	</div>
</div>