<img style="height: 100px;" src="<?php echo YiiBase::getPathOfAlias('webroot.externals.recruitment.images').'/'?>logo_pln.png" alt="">
<h1>KARTU PESERTA rekruitment pln</h1>

<ul>
    <li>Nama : <?php echo $model->user->displayname; ?></li>
    <li>No Tes : <?php echo strtoupper($model->eventUser->test_number); ?></li>
    <li>Bidang : <?php echo $model->eventUser->major; ?></li>
    <li>Batch : </li>
    <li>No Meja : </li>
</ul>

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