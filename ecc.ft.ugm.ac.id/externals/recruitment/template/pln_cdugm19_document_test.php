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
		font-size: 18px; 
		line-height: 24px;
		font-weight: 400;
	}
	html {width: 297; height: 210mm;}	
	a {color: blue;}
	table.event td {
		vertical-align: top;
		padding-top: 0;
		padding-bottom: 5px;
		padding-right: 10px;
	}
	table.list {
		border-spacing: 0;
		border-collapse: collapse;
	}
	table.list th {
		border: none;
		padding: 8px 0;
		border-bottom: 1px solid #000;
	}
	table.list td {
		border: 1px solid #000;
		padding: 2px 10px;
		vertical-align: middle;
		text-align: center;
	}
	table.list .title-score td {
		padding: 3px;
		width: 100px;
	}
	table.list .score td {
		text-align: left;
		height: 60px;
		font-size: 14px;
		vertical-align: top;
		padding: 5px;
	}
	table.user {
	}
	table.user td {
		border: none;
		text-align: left;
		padding: 5px 0;
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

<page backtop="10mm" backbottom="10mm" backleft="12mm" backright="12mm" style="font-size: 12pt">
<div class="member-card">
	
<?php if($model != null) {
	$i = 0;
	$documentCount = count($model);
	foreach($model as $key => $val) {
	$i++;
	if($i == 1) {?>
		<table class="list" style="width: 100%;">
	<?php }?>
		<tr>
			<th colspan="4" style="width: 50%;">
				<img src="<?php echo YiiBase::getPathOfAlias('webroot'); ?>/externals/recruitment/images/pln-logo.png" />
			</th>
			<th colspan="4" style="width: 50%; text-align: right;">
				<img src="<?php echo YiiBase::getPathOfAlias('webroot'); ?>/externals/recruitment/images/logo-ecc.png" />
			</th>
		</tr>
		<tr>
			<td rowspan="3"><?php echo $val->session_seat; ?></td>
			<td rowspan="3" style="width: 50px;"><span>FOTO<br/>3 x 4</span></td>
			<td colspan="6" style="text-align: left;">
				<table class="user">
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
						<td><?php echo strtoupper($val->eventUser->major); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="title-score">
			<td>TES<br/>INTELEGENSI</td>
			<td>TES<br/>AKD-ING</td>
			<td>PSIKOTES</td>
			<td>TES FISIK</td>
			<td>TES LAB & <br/>PENUNJANG</td>
			<td>WAWANCARA</td>
		</tr>
		<tr class="score">
			<td>Tanggal :</td>
			<td>Tanggal :</td>
			<td>Tanggal :</td>
			<td>Tanggal :</td>
			<td>Tanggal :</td>
			<td>Tanggal :</td>
		</tr>
		<tr>
			<td colspan="8" style="border: none;">&nbsp;</td>
		</tr>
	<?php if($i%2 == 0) {?>
		</table>
		<table class="list" style="width: 100%;">
	<?php }
	if($i == $documentCount) {?>
		</table>
	<?php }
	}
}?>
</div>
</page>


