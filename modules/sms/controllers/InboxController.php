<?php
/**
 * InboxController
 * @var $this InboxController
 * @var $model SmsInbox
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Receiver
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 04:06 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class InboxController extends Controller
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
		$arrThemes = Utility::getCurrentTemplate('public');
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
				'actions'=>array('index', 'receiver'),
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
		$this->redirect(array('o/inbox/manage'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionReceiver() 
	{
		//if($_SERVER["SERVER_ADDR"] != '127.0.0.1' && $_SERVER["HTTP_HOST"] != 'localhost')
			//exit();
		
		$requests = $_REQUEST;
		//print_r($requests);
		$smsc_source = $requests['Q'];
		$smsc_sender = $requests['q'];
		$sender_nomor = $requests['p'];
		$message = $requests['a'];
		$status = $requests['d'];
		$message_date = $requests['t'];
		
		if ($smsc_source && $smsc_sender && $sender_nomor && $message && $status && $message_date) {
			$model=new SmsInbox;
			$model->smsc_source = $smsc_source;
			$model->smsc_sender = $smsc_sender;
			$model->sender_nomor = $sender_nomor;
			$model->message = $message;
			$model->status = $status;
			$model->message_date = $message_date;
			$model->save();
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
		$model = SmsInbox::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sms-inbox-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
