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
	public static function sendSMS($smslog_id, $user_id, $d_nomor, $d_message) {
		$status = false;
		
		$message_type = 1; // text, default
		$dlr_url = 'http://192.168.43.187/_client_bpadjogja.info/'.Yii::app()->createUrl('sms/o/outbox/dlr', array('type' => '%d', 'smslog_id' =>$smslog_id, 'user_id' =>$user_id));
		$d_message = urlencode(iconv('utf-8', 'ucs-2', $d_message));
		
		$URL = 'http://192.168.43.245:13013/cgi-bin/sendsms?user=admin&password=adminadmin&to={$d_nomor}&text={$d_message}';
		$URL .= '&charset=UCS-2';
		$URL .= '&coding=2';
		$URL .= '&dlr-mask=31';
		$URL .= '&dlr-url='.urlencode($dlr_url);
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
	
	public static function setSmsDeliveryStatus($smslog_id, $user_id, $c_status) {
		$status = false;		
		
		Yii::import('application.modules.sms.models.SmsOutbox');
		$model = SmsOutbox::model()->find(array(
			'condition' => "smslog_id=:smslog AND user_id=:user",
			'params' => array(
				':smslog'=>$smslog_id,
				':user'=>$user_id,
			),
		));
		
		if($model != null) {
			$model->status =$c_status;
			if($model->save(false))				
				$status = true;
		}
		
		return $status;
	}
}
