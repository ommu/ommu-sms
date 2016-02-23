<?php
/**
 * Visits (visits)
 * @var $this SiteController
 * @var $data Visits
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="sep mb-10">
	<?php echo $data->guest_TO->organization == 1 ? "organisasi" : "personal"?>:
	<?php echo $data->guest_TO->organization == 1 ? ($data->guest_TO->author_id != 0 ? $data->guest_TO->organization_name." (".$data->guest_TO->author_TO->name.")" : $data->guest_TO->organization_name) : $data->guest_TO->author_TO->name?><br/>
	<?php echo $data->guest_TO->visitor.' orang';?><br/>
	<?php echo $data->start_date.' - '.$data->finish_date?>
</div>