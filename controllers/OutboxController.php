<?php
/**
 * OutboxController
 * @var $this OutboxController
 * @var $model SmsOutbox
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Dlr
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 04:07 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 *----------------------------------------------------------------------------------------------------------
 */

class OutboxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','dlr'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('manage'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionDlr() 
	{
		//if($_SERVER["SERVER_ADDR"] != '127.0.0.1' && $_SERVER["HTTP_HOST"] != 'localhost')
		//	exit();
		
		$requests = $_REQUEST;
		$type = $requests['type'];
		$outbox_id = $requests['outbox_id'];
		$user_id = $requests['user_id'];
		$smsc_s = $requests['smsc_s'];
		$smsc_d = $requests['smsc_d'];
		
		if ($type && $outbox_id && $user_id) {
			$stat = 0;
			switch ($type) {
				case 1: $stat = 6; break;	// delivered to phone = delivered 3
				case 2: $stat = 5; break;	// non delivered to phone = failed 2 
				case 4: $stat = 3; break;	// queued on SMSC = pending 0 
				case 8: $stat = 4; break;	// delivered to SMSC = sent 1
				case 16: $stat = 5; break;	// non delivered to SMSC = failed 2
				case 9: $stat = 4; break;	// sent 1
				case 12: $stat = 4; break;	// sent 1
				case 18: $stat = 5; break;	// failed 2
			}
			$c_status = $stat;
			if ($stat) {
				$c_status = $stat - 3;
			}			
			SmsUtility::setSmsDeliveryStatus($outbox_id, $user_id, $c_status, $smsc_s, $smsc_d);
			
			$conn  = Yii::app()->db;
			$query = "SELECT dlr_id FROM ommu_sms_kannel_dlr WHERE smslog_id='$outbox_id'";
			$command = $conn->createCommand($query);
			$result  = $command->query();
			if($result->rowCount > 0) {
				$sql = "UPDATE ommu_sms_kannel_dlr SET dlr_type='$type', c_timestamp='".time()."' WHERE smslog_id='$outbox_id'";
				$command = $conn->createCommand($sql);
				$command->query();				
			} else {
				$sql = "INSERT INTO ommu_sms_kannel_dlr (dlr_type, smslog_id) VALUES ('$type', '$outbox_id')";
				$command = $conn->createCommand($sql);
				$command->query();				
			}			
		}
		exit();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = SmsOutbox::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sms-outbox-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
