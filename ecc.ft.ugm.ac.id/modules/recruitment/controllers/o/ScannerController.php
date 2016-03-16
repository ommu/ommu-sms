<?php
/**
 * ScannerController
 * @var $this ScannerController
 * @var $model Recruitments
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	View
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 March 2016, 23:23 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class ScannerController extends Controller
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
			} else {
				$this->redirect(Yii::app()->createUrl('site/login'));
			}
		} else {
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
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
				'actions'=>array('manage','view'),
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
		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish';
		$criteria->params = array(':publish'=>1);
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('Recruitments', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->pageTitle = 'Recruitments';
		$this->pageDescription = $setting->meta_description;
		$this->pageMeta = $setting->meta_keyword;
		$this->render('admin_index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);

		$this->pageTitle = 'View Recruitments';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view',array(
			'model'=>$model,
		));
	}	

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		if($_POST['barcodeField'] != '') {
			$barcode = $_POST['barcodeField'];
			$eventId = (int)substr($barcode,0,2);
			$batchId = (int)substr($barcode,2,3);
			$userId = (int)substr($barcode,5,6);
			$scanner = substr($barcode,11,1);
			//echo $eventId.' '.$batchId.' '.$userId;
			
			$eventUser = RecruitmentEventUser::model()->find(array(
				'condition' => 'publish= :publish AND recruitment_id= :recruitment AND user_id= :user',
				'params'    => array(
					':publish' => 1,
					':recruitment' => $eventId,
					':user' => $userId,
				),
			));		
		}
		if($_POST['testnumberField'] != '') {
			$eventUser = RecruitmentEventUser::model()->find(array(
				'condition' => 'publish= :publish AND test_number= :test_number',
				'params'    => array(
					':publish' => 1,
					':test_number' => strtolower(trim($_POST['testnumberField'])),
				),
			));
			$eventId = $eventUser->recruitment_id;
			$userId = $eventUser->user_id;
		}
		
		$event = Recruitments::model()->findByPk($eventId);
		$user = RecruitmentUsers::model()->findByPk($userId);
		
		$sessionActive = RecruitmentSessionUser::model()->find(array(
			'with' => array(
				'session' => array(
					'alias'=>'session',
				),
			),
			'condition' => 't.publish= :tpublish AND t.user_id= :user AND session.publish= :spublish AND session.session_date= :session_date AND session.recruitment_id= :recruitment',
			'params'=> array(
				':tpublish' => 1,
				':user' => $userId,
				':spublish' => 1,
				':session_date' => date('Y-m-d'),
				//':session_date' => '2016-03-14',
				':recruitment' => $eventId,
			),
		));
		if($sessionActive != null) {
			if($scanner != null) {
				RecruitmentSessionUser::model()->updateByPk($sessionActive->id, array(
					'scanner_status'=>1,
					'scanner_field'=>1,
					'scanner_id'=>Yii::app()->user->id,
				));
				
			} else {
				RecruitmentSessionUser::model()->updateByPk($sessionActive->id, array(
					'scanner_status'=>1,
					'scanner_id'=>Yii::app()->user->id,
				));
			}
		}
		
		if(!Yii::app()->request->isAjaxRequest) {
			$this->pageTitle = 'Scanner';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_manage', array(
				'event'=>$event,
				'user'=>$user,
				'eventUser'=>$eventUser,
				'sessionActive'=>$sessionActive,
			));
		} else {
			$this->renderPartial('admin_manage', array(
				'event'=>$event,
				'user'=>$user,
				'eventUser'=>$eventUser,
				'sessionActive'=>$sessionActive,
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = Recruitments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Phrase::trans(193,0));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recruitments-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
