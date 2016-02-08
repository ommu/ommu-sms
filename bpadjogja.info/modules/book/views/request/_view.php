<?php
/**
 * Book Requests (book-requests)
 * @var $this RequestController * @var $data BookRequests *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<div class="sep">
	<?php $author = $data->book_relation->author();
		$item = '';
		$i = 0;
		foreach($author as $key => $row) {
			$i++;
			if($i == 1)
				$item .= $row->author_relation->author_name;
			else
				$item .= ', '.$row->author_relation->author_name;
		}
	?>
	<h3><?php echo $data->book_relation->title;?> oleh <?php echo $item;?></h3>
	<div class="meta-date clearfix">
	</div>
	<div class="meta-date clearfix">
		<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($data->creation_date, true);?></span>
		<span class="by"><i class="fa fa-user"></i>&nbsp;<?php echo ucwords($data->requester_relation->name);?></span>
		<span class="date"><i class="fa fa-book"></i>&nbsp;<?php echo $data->book_relation->publisher->publisher_name;?></span>
	</div>
</div>