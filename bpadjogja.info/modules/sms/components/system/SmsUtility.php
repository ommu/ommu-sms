<?php
/**
 * SmsUtility class file
 *
 * Contains many function that most used :
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @created date 11 February 2016, 18:56 WIB
 * @version 1.0
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

class SmsUtility
{
	public static function sendSMS($outbox_id, $user_id, $d_nomor, $d_message) {
		$status = false;
		
		$message_type = 1; // text, default
		//$url = 'http://192.168.3.13'; 			//swevel wifi
		$url = 'http://192.168.43.187'; 		//android wifi
		//$url = 'http://localhost/bpadportal'; 	//localhost bpadjogja.info
		
		$dlr_url = 'http://192.168.43.187'.Yii::app()->createUrl('sms/outbox/dlr', array('type' => '%d', 'outbox_id' =>$outbox_id, 'user_id' =>$user_id, 'smsc_s'=>'%Q', 'smsc_d'=>'%q'));
		$d_message = urlencode(iconv('utf-8', 'ucs-2', $d_message));
		
		//$urlKannel = 'http://192.168.3.54'; 			//swevel wifi
		$urlKannel = 'http://192.168.43.245'; 			//android wifi
		//$urlKannel = 'http://localhost'; 				//localhost bpadjogja.info
		
		$URL = 'http://192.168.43.245:13013/cgi-bin/sendsms?user=admin&password=adminadmin&to='.$d_nomor.'&text='.$d_message;
		$URL .= '&charset=utf8';
		$URL .= '&coding=2';
		$URL .= '&dlr-mask=31';
		$URL .= '&dlr-url='.$dlr_url;
		$URL .= '&mclass='.$message_type;
		$URL = str_replace("&&", "&", $URL);
		
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$result = curl_exec($ch);
		file_put_contents('assets/cek_sms_sent.txt', $result.'#'.$URL);
		if(curl_close($ch))
			$status = true;
		
		return $status;
	}
	
	public static function setSmsDeliveryStatus($outbox_id, $user_id, $c_status, $smsc_s, $smsc_d) {
		$status = false;		
		
		Yii::import('application.modules.sms.models.SmsOutbox');
		$model = SmsOutbox::model()->find(array(
			'condition' => "outbox_id=:outbox AND user_id=:user",
			'params' => array(
				':outbox'=>$outbox_id,
				':user'=>$user_id,
			),
		));
		
		if($model != null) {
			$model->status = $c_status;
			$model->smsc_source = $smsc_s;
			$model->smsc_destination = $smsc_d;
			if($model->save(false))				
				$status = true;
		}
		
		return $status;
	}
}
