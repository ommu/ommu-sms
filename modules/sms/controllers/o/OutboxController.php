<?php
/**
 * OutboxController
 * @var $this OutboxController
 * @var $model ViewSmsOutbox
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	View
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 15 February 2016, 11:43 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
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
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = Utility::getCurrentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','view','sync'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && in_array(Yii::app()->user->level, array(1,2))',
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
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new ViewSmsOutbox('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ViewSmsOutbox'])) {
			$model->attributes=$_GET['ViewSmsOutbox'];
		}

		$columnTemp = array();
		if(isset($_GET['GridColumn'])) {
			foreach($_GET['GridColumn'] as $key => $val) {
				if($_GET['GridColumn'][$key] == 1) {
					$columnTemp[] = $key;
				}
			}
		}
		$columns = $model->getGridColumn($columnTemp);

		$this->pageTitle = 'View Sms Outboxes Manage';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$model=new SmsOutbox;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SmsOutbox'])) {
			$model->attributes=$_POST['SmsOutbox'];
			
			/*
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						SmsUtility::sendSMS($model->outbox_id, Yii::app()->user->id, $model->destination_nomor, $model->message);
						if(isset($_GET['type']) && $_GET['type'] == 'inbox')
							$url = Yii::app()->controller->createUrl('o/inbox/manage');
						else
							$url = Yii::app()->controller->createUrl('manage');
						echo CJSON::encode(array(
							'type' => 5,
							'get' => $url,
							'id' => 'partial-sms-outbox',
							'msg' => '<div class="errorSummary success"><strong>SmsOutbox success created.</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			*/
			
			if($model->validate()) {
				$outboxGroup = SmsOutboxGroup::insertOutboxGroup();
				if($model->messageType == 1) {
					$model->group_id = $outboxGroup;
					$phonebook = SmsPhonebook::setPhoneNumber($model->destination_nomor, 'nasional');
					if($model->save())
						SmsUtility::sendSMS($model->outbox_id, Yii::app()->user->id, $phonebook, $model->message);
					
				} else if($model->messageType == 2) {
					if($model->validate()) {}
					
				} else if($model->messageType == 3) {
					$groupbook = SmsGroupPhonebook::model()->findAll(array(
						'condition' => 'group_id=:group',
						'params'    => array(
							':group' => $model->group_input,
						),
					));
					if($groupbook != null) {
						foreach($groupbook as $key => $val) {
							$outbox_id = SmsOutbox::insertOutbox($val->phonebook_TO->phonebook_nomor, $model->message, $outboxGroup);
							$phonebook = SmsPhonebook::setPhoneNumber($val->phonebook_TO->phonebook_nomor, 'nasional');
							SmsUtility::sendSMS($outbox_id, Yii::app()->user->id, $phonebook, $model->message);
						}
					}
				}
			
				if(isset($_GET['type']) && $_GET['type'] == 'inbox')
					$url = Yii::app()->controller->createUrl('o/inbox/manage');
				else
					$url = Yii::app()->controller->createUrl('manage');
				$this->redirect($url);
			}
		
		}
		//} else {
			$this->dialogDetail = true;
			if(isset($_GET['inbox']) && $_GET['inbox'] == 'active')
				$url = Yii::app()->controller->createUrl('o/inbox/manage');
			else
				$url = Yii::app()->controller->createUrl('manage');
			$this->dialogGroundUrl = $url;
			$this->dialogWidth = 600;

			$this->pageTitle = 'Create Sms Outboxes';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_add',array(
				'model'=>$model,
			));			
		//}
		
		ob_end_flush();		
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'View View Sms Outboxes';
		$this->pageDescription = '';
		$this->pageMeta = $setting->meta_keyword;
		$this->render('admin_view',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionSync() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$outboxView = ViewSmsOutbox::model()->findAll();
		if($outboxView != null) {
			foreach($outboxView as $key => $val) {
				$message = $val->message;
				$outboxGroup = SmsOutboxGroup::insertOutboxGroup();
				
				$outbox = SmsOutbox::model()->findAll(array(
					'condition' => 'group_id=:group AND message=:message',
					'params'    => array(
						':group' => 0,
						':message' => $message,
					),
				));
				if($outbox != null) {
					foreach($outbox as $key => $row) {
						SmsOutbox::model()->updateByPk($row->outbox_id, array('group_id'=>$outboxGroup));						
					}
				}
			}
		}
		
		ob_end_flush();
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = ViewSmsOutbox::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='view-sms-outbox-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
