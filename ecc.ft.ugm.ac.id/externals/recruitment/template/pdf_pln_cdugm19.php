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
		font-size: 13px; 
		line-height: 18px;
		font-weight: 400;
	}
	html {width: 210mm; height: 297mm;}	
	a {color: blue;}
	table.event td {
		vertical-align: top;
		padding-top: 0;
		padding-bottom: 5px;
		padding-right: 10px;
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
	<table style="width: 100%;">
		<tr>
			<td style="width: 50%; vertical-align: middle; padding-bottom: 20px;">
				<img style="height: 100px;" src="<?php echo YiiBase::getPathOfAlias('webroot.externals.recruitment.images').'/'?>logo_pln.png" alt="">
			</td>
			<td style="width: 50%; vertical-align: middle; padding-bottom: 20px; padding-right: 20px; text-align: right;">
				<img style="height: 100px;" src="<?php echo YiiBase::getPathOfAlias('webroot.externals.recruitment.images').'/'?>ecc_logo.jpg" alt="">
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%; vertical-align: middle;">
	<div style="padding-bottom: 15px;">
		<strong>UNDANGAN PANGGILAN TES</strong><br/>
		<strong>PT PLN (Persero)</strong><br/>
		<strong>REKRUTMEN UMUM LOKASI : YOGYAKARTA</strong><br/>
		<strong>MELALUI CAREER DAYS UGM 19</strong><br/>
		<strong>TINGKAT S1/D.IV/D.III TAHUN 2016</strong>	
	</div>
	
	<div style="padding-bottom: 15px;">	
		Kepada Yth.<br/>
		Sdr/ i. <?php echo $model->user->displayname; ?><br/>
		<?php echo strtoupper($model->eventUser->test_number); ?><br/>
		<?php echo $model->eventUser->major; ?>
	</div>
			</td>
			<td style="width: 50%; vertical-align: top; text-align: right; padding-right: 20px; padding-top: 30px;">
	<?php
		$text = str_pad($model->session->recruitment_id, 2, '0', STR_PAD_LEFT).''.str_pad($model->session_id, 3, '0', STR_PAD_LEFT).''.str_pad($model->user_id, 6, '0', STR_PAD_LEFT);
		Yii::import('ext.php-barcodes.DNS1DBarcode');	
		$barcode = new DNS1DBarcode();
		$barcode->save_path=YiiBase::getPathOfAlias('webroot.public.recruitment.user_barcode').'/';
	?>
	<span style="display: inline-block; text-align: right;">
		<img style="display: block; width: 180px;" src="<?php echo $barcode->getBarcodePNGPath($text, 'UPCA', 2, 50); ?>" /><br/>
		<span><strong><?php echo $text;?></strong> |OMMU</span>
	</span>
			</td>
		</tr>
	</table>
	
	<div style="padding-bottom: 15px;">Di Tempat</div>
	
	<div style="padding-bottom: 15px;">Sehubungan dengan proses rekrutmen dan seleksi untuk Program Rekrutmen Umum Lokasi Yogyakarta melalui Career Days UGM 19 Tingkat S.1/D.IV/D.III tahun 2016 PT PLN (Persero) diharapkan kehadiran saudara/ i untuk mengikuti:</div>
	
	<div style="padding-bottom: 10px;">	
		<strong>General Aptitude Test (GAT)</strong><br/>
		yang akan dilaksanakan pada:
		<table class="event">
			<tr>
				<td style="padding-right: 30px;">Hari/ Tanggal</td>
				<td>:</td>
				<td><?php echo Utility::getLocalDayName($model->session->session_date, false);?>/ <?php echo date('d', strtotime($model->session->session_date))." ".Utility::getLocalMonthName($model->session->session_date)." ".date('Y', strtotime($model->session->session_date)); ?></td>
			</tr>
			<tr>
				<td style="padding-right: 30px;">Tempat</td>
				<td>:</td>
				<td>R. Utama lantai 2 Grha Sabha Pramana UGM, Bulaksumur UGM.</td>
			</tr>
			<tr>
				<td style="padding-right: 30px;">Waktu</td>
				<td>:</td>
				<td><?php echo $model->session->session_name; ?>, <?php echo $model->session->session_time_start; ?> - <?php echo $model->session->session_time_finish; ?> WIB</td>
			</tr>
		</table>
	</div>
	
	<div style="padding-bottom: 10px;">	
		<ul style="margin-left: -40px;">
			<li style="padding-bottom: 10px; padding-left: 10px;">Wajib hadir <strong>60 menit sebelum jadwal</strong> yang ditentukan untuk keperluan <strong>registrasi ulang</strong>.</li>
			<li style="padding-bottom: 10px; padding-left: 10px;">Peserta hanya dapat mengikuti tes sesuai jadwal/ batch yang telah ditentukan.</li>
			<li style="padding-bottom: 10px; padding-left: 10px;;">Peserta yang <strong>TERLAMBAT</strong> akan dinyatakan <strong>GUGUR</strong>.</li>
			<li style="padding-bottom: 10px; padding-left: 10px;;">Peserta wajib <strong>MEMBAWA BUKTI</strong> untuk dapat mengikuti seleksi ini, berupa:
				<ol style="margin-left: -40px; margin-top: 10px;">
					<li style="padding-bottom: 10px; padding-left: 10px;"><em>Print out</em> Surat Undangan Panggilan Tes ini;</li>
					<li style="padding-bottom: 10px; padding-left: 10px;">Pas Foto Berwarna Ukuran 3x4 sebanyak 2 buah ke lokasi tes;</li>
					<li style="padding-bottom: 10px; padding-left: 10px;">KTP/ SIM/ kartu identitas yang berlaku.</li>			
				</ol>
			</li>
		</ul>
	</div>
	
	<div style="padding-bottom: 10px;">	
		<strong>Mohon Diperhatikan:</strong><br/>
		<ol style="margin-left: -20px; margin-top: -10px;">
			<li style="padding-bottom: 10px;">Peserta wajib berpakaian sopan dan rapi, menggunakan kemeja dan celana/ bawahan kain, tidak mengenakan pakaian ketat, jeans, t-shirt atau sandal/ sepatu sandal;</li>
			<li style="padding-bottom: 10px;">Peserta agar membawa alat tulis: pensil 2B, pensil HB, penghapus, ballpoint, papan alas, tipe-X, dan lem, beserta cadangannya;</li>
			<li style="padding-bottom: 10px;">Setiap pengumuman ataupun informasi mengenai rekrutmen PLN hanya melalui website PT PLN (Persero) <a href="http://www.pln.co.id" title="www.pln.co.id">www.pln.co.id</a> dan website ECC UGM <a href="http://www.ecc.ft.ugm.ac.id" title="www.ecc.ft.ugm.ac.id">www.ecc.ft.ugm.ac.id</a>;</li>
			<li style="padding-bottom: 10px;">Peserta agar berhati-hati terhadap segala usaha dan bentuk penipuan yang mengatasnamakan rekrutmen PLN. PLN tidak pernah memungut biaya terhadap keseluruhan proses seleksi</li>
			<li style="padding-bottom: 10px;">Peserta yang dinyatakan lulus GAT, akan mengikuti Tes Akademik dan Bahasa Inggris pada Selasa, 15 Maret 2016.</li>
			<li style="padding-bottom: 10px;">Peserta yang dinyatakan lulus Tes Akademik dan Bahasa Inggris, akan mengikuti Psikotes pada Rabu, 16 Maret 2016.</li>
		</ol>
	</div>
	
	<div class="copyright">
		Generate by <a href="http://company.ommu.co" title="Ommu Platform">Ommu Platform</a>
	</div>
	
</div>
</page>


