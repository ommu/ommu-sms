<?php
/**
 * SmsUtility class file
 *
 * Contains many function that most used :
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @created date 11 February 2016, 18:56 WIB
 * @version 1.0
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 */

class SmsUtility
{
	public static function sendSMS($outbox_id, $user_id, $d_nomor, $d_message) 
	{
		$smsGatewayConnected = SmsUtility::getConnected();
		
		if($smsGatewayConnected != 'neither-connected') {
			$status = false;			
			$message_type = 1; // text, default
			
			if(in_array($smsGatewayConnected, array('http://103.255.15.100','http://localhost','http://127.0.0.1','http://192.168.30.100')))
				$smsGatewayConnectedPath = $smsGatewayConnected.'/bpadportal';
			else
				$smsGatewayConnectedPath = $smsGatewayConnected;
			
			$dlr_url = $smsGatewayConnectedPath.preg_replace('('.Yii::app()->request->baseUrl.')', '', Yii::app()->createUrl('sms/outbox/dlr', array('type' => '%d', 'outbox_id' =>$outbox_id, 'user_id' =>$user_id, 'smsc_s'=>'%Q', 'smsc_d'=>'%q')));
			$d_message = urlencode(iconv('utf-8', 'ucs-2', $d_message));
			
			$URL = $smsGatewayConnected.':13013/cgi-bin/sendsms?user=admin&password=adminadmin&to='.$d_nomor.'&text='.$d_message;
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
			file_put_contents('assets/sms_sent_check.txt', $result.'#'.$URL);
			if(curl_close($ch))
				$status = true;
			
			return $status;
			
		} else
			return false;
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

	/**
	 * get alternatif connected domain for smsgateway
	 * @param type $operator not yet using
	 * @return type
	 */
	public static function getConnected() {
		$smsServerOptions = Yii::app()->params['sms_server_options'];
		$connectedUrl = 'neither-connected';
		
		foreach ($smsServerOptions as $val) {
			if (SmsUtility::isServerAvailible($val)) {
				$connectedUrl = $val;
				break;
			}
		}

		file_put_contents('assets/sms_server_actived.txt', $connectedUrl);

		return $connectedUrl;
	}

	//returns true, if domain is availible, false if not
	public static function isServerAvailible($domain) 
	{
		//check, if a valid url is provided
		if (!filter_var($domain, FILTER_VALIDATE_URL))
			return false;

		//initialize curl
		$curlInit = curl_init($domain);
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

		//get answer
		$response = curl_exec($curlInit);
		curl_close($curlInit);
		if($response)
			return true;

		return false;
	}
}
