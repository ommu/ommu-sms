<style type="text/css">
	/* Global */
	html {width: 240mm; height:280mm;}
	html, body, table, tr, td, div{margin: 0; padding: 0; font-family: arial, tahoma; font-size: 14px;}
	table {margin: 10px; float: left; width: 100mm; height: 135mm; border: 0; border-spacing: 0; border-collapse: collapse;}
	table tr td {padding: 5px;border: 1px solid #000; width: 30%; text-align: center;}
	table table {margin: 0; float: none; width: auto; height: auto;}
	table table tr td {border: none; vertical-align: top; text-align: left; padding: 5px 0 0 0; width: auto;}
	table table tr td.barcode {text-align: center;}
	table tr.title td {height: 40px;}
	table tr.score td {height: 50px;}
</style>

<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">
<?php foreach($models as $model) { ?>       
    
       

	<table>
		<tr>
			<td colspan="3">
				<img  src="<?php echo Yii::app()->baseUrl.'/externals/recruitment/images/'?>recruit-pln.png" alt="">
			</td>
		</tr>
		<tr>
			<td style="height: 241px;" rowspan="2">
				<table width="100%">
					<tr>
						<td colspan="3" style="height: 115px; text-align: center;vertical-align:middle;">FOTO<br/>3 X 4</td>
					</tr>
					<tr>
						<td>BATCH</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo $model->session->session_name ?></td>
					</tr>
					<tr>
						<td>NO MEJA</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo $model->session_seat; ?></td>
					</tr>
				</table>
			</td>
			<td style="height: 214px;" colspan="2">
				<b>KARTU PESERTA<br/>SELEKSI PENERIMAAN PEGAWAI<br/>PT PLN (PERSERO)</b>
				<table>
					<tr>
						<td>NAMA</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo $model->user->displayname; ?></td>
					</tr>
					<tr>
						<td>NO TES</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo strtoupper($model->eventUser->test_number); ?></td>
					</tr>
					<tr>
						<td>BIDANG</td>
						<td>&nbsp;:&nbsp;</td>
						<td><?php echo $model->eventUser->major; ?></td>
					</tr>
					<tr>
						<td class="barcode" colspan="3">
                                                        <?php $text = str_pad($model->session->recruitment_id, 2, '0', STR_PAD_LEFT).''.str_pad($model->session_id, 3, '0', STR_PAD_LEFT).''.str_pad($model->user_id, 6, '0', STR_PAD_LEFT); ?>
                                                        <?php $pathBarcode =  'user_barcode_'.$typeBarcode; ?>
							<img style="display: block; margin:0 auto" src="<?php echo Yii::app()->baseUrl.'/public/recruitment/'.$pathBarcode.'/'.$text.'.png' ?>" />
                                                        <span><strong><?php echo $text;?></strong></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:11px;"><i><b>KARTU INI HARUS DIBAWA SETIAP MENGIKUTI TES/SELEKSI</b></i></td>
		</tr>
		<tr class="title">
			<td><b>GAT</b></td>
			<td><b>TES AKD-ING</b></td>
			<td><b>PSIKOTES</b></td>
		</tr>
		<tr class="score">
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr class="title">
			<td><b>TES FISIK</b></td>
			<td><b>TES LAB & PENUNJANG</b></td>
			<td><b>WAWANCARA</b></td>
		</tr>
		<tr class="score">
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	

<?php } ?>
</page>