<style type="text/css">
	html, body, div, span, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, code,
	del, dfn, em, img, q, dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	input, button, select, textarea,
	table, caption, tbody, tfoot, thead, tr, th, td,
	article, aside, details, figcaption, figure, footer, header,
	hgroup, nav, section {
		color: #111; 
		font-size: 15px; 
		line-height: 20px;
		font-weight: 400;
	}
	html {width: 297; height: 210mm;}	
	a {color: blue;}
	table.list {
		border-spacing: 0;
		border-collapse: collapse;
	}
	table.list th {
		border: none;
		padding: 0 20px 20px 20px;
		border-bottom: 1px solid #000;
	}
	table.list td {
		border: 1px solid #000;
		padding: 2px 10px;
		vertical-align: middle;
		text-align: center;
	}
	table.list td.user {
		padding: 10px 10px 10px 10px;		
	}
	table.list td.user table td {
		padding: 0 10px 2px 0;
		border: none;
		text-align: left;
		font-size: 18px;
		line-height: 18px;
	}
	table.list tr.title-score td {
		padding: 7px 10px;
	}
	table.list tr.score td {
		vertical-align: top;
		text-align: left;
		padding-top: 5px;
		font-size: 13px;
		line-height: 17px;
	}
	
	div.copyright,
	div.copyright * {
		font-size: 12px;
		line-height: 15px;
		color: #bbb;
	}
	div.copyright {
		padding-top: 3px;
		border-top: 1px dotted #bbb;
		text-align: right;
	}
	div.copyright a {
		color: #aaa;
	}
</style>

<page backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
<div class="member-card">
	
<?php if($model != null) {
	$batch = RecruitmentSessions::model()->findByPk($_GET['session']);
	
	$session = $batch->recruitment->view->sessions;
	$column = 2+$session;
	if($column%2 == 0)
		$LColspan = $RColspan = $column/2;
	else {
		$LColspan = (int)($column/2);
		$RColspan = $LColspan+1;
	}
	$sessionPublish = $batch->recruitment->sessionPublish;
	
	$i = 0;
	$document = count($model);
	foreach($model as $key => $val) {
	$i++;
	if($i == 1) {?>
		<table class="list" style="width: 100%; border: 1px solid #ff0000;">
	<?php }?>
		<tr>
			<th colspan="<?php echo $LColspan;?>" style="width: 50%;">
				<?php if($batch->recruitment->event_logo == '')
					$images = YiiBase::getPathOfAlias('webroot.public.recruitment').'/recruitment_default.png';
				else {
					$images = YiiBase::getPathOfAlias('webroot.public.recruitment').'/'.$batch->recruitment->event_logo;
					if(!file_exists($images))
						$images = YiiBase::getPathOfAlias('webroot.public.recruitment').'/recruitment_default.png';
				}?>
				<img style="height: 100px;" src="<?php echo $images;?>" alt="">
			</th>
			<th colspan="<?php echo $RColspan;?>" style="width: 50%; text-align: right;">
				<img style="height: 100px;" src="<?php echo YiiBase::getPathOfAlias('webroot.externals.recruitment.images').'/'?>ecc_logo.jpg" alt="">
			</th>
		</tr>
		<tr>
			<td rowspan="3"><?php echo $val->session_seat; ?></td>
			<td rowspan="3" style="width: 80px;"><span>FOTO<br/>3 x 4</span></td>
			<td colspan="<?php echo $session;?>" class="user" style="text-align: left;">
				<table>
					<tr>
						<td>NAMA</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo strtoupper($val->user->displayname); ?></td>
					</tr>
					<tr>
						<td>NO TEST</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo strtoupper($val->eventUser->test_number); ?></td>
					</tr>
					<tr>
						<td>BIDANG</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo strtoupper($val->user->major); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="title-score">
			<?php foreach($sessionPublish as $key => $row) {?>
				<td style=""><?php echo strtoupper($row->session_code);?></td>
			<?php }?>
		</tr>
		<tr class="score">
			<?php foreach($sessionPublish as $key => $row) {
				$date = !in_array($row->session_date, array('0000-00-00','1970-01-01')) ? date('d', strtotime($row->session_date))." ".Utility::getLocalMonthName($row->session_date)." ".date('Y', strtotime($row->session_date)) : '';?>
				<td style="width: 30px; height: 60px;">Tanggal : <?php echo $date;?></td>
			<?php }?>
		</tr>
		<?php if($i%2 != 0) {?>
		<tr>
			<td colspan="8" style="height: 30px; vertical-align: middle; text-align: center; color: #bbb; padding-top: 10px; border: none;">
				-----------------------------------------------------------------------------------------------------------------------
			</td>
		</tr>
		<?php }?>
	<?php if($i%2 == 0) {?>
		</table>
		<table class="list" style="width: 100%; border: 1px solid #ff0000;">
	<?php }
	if($i == $document) {?>
		</table>
	<?php }
	}
}?>
</div>
</page>


