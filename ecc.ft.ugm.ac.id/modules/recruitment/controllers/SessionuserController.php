<?php
/**
 * SessionuserController
 * @var $this SessionuserController
 * @var $model RecruitmentSessionUser
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Add
 *	Edit
 *	RunAction
 *	Delete
 *	Publish
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:53 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SessionuserController extends Controller
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
				'actions'=>array('index'),
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
	 * Manages all models.
	 */
	public function actionGenerate($id=null) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		if($id == null || Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->createUrl('site/index'));
			
		$model=$this->loadModel($id);
		echo $model->getPdf($model, true);
	}

	/**
	 * Manages all models.
	 */
	public function actionSendEmail($id=null) 
	{		
		ini_set('max_execution_time', 0);
		ob_start();
		
		if($id == null || Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->createUrl('site/index'));
			
		$model=$this->loadModel($id);
		$search		= array(
			'{$displayname}', '{$test_number}', '{$major}',
			'{$batch_day}', '{$batch_data}','{$batch_month}', '{$batch_year}',
			'{$session_date}', '{$session_time_start}', '{$session_time_finish}');
		$replace	= array(
			$model->user->displayname, strtoupper($model->eventUser->test_number), $model->user->major,
			Utility::getLocalDayName($model->session->session_date, false), date('d', strtotime($model->session->session_date)), Utility::getLocalMonthName($model->session->session_date), date('Y', strtotime($model->session->session_date)),
			$model->session->session_name, $model->session->session_time_start, $model->session->session_time_finish);
		$template = 'pln_cdugm19_mail';
		$message = file_get_contents(YiiBase::getPathOfAlias('webroot.externals.recruitment.template').'/'.$template.'.php');
		$message = str_ireplace($search, $replace, $message);
		$attachment = $model->getPdf($model);
		SupportMailSetting::sendEmail($model->user->email, $model->user->displayname, 'UNDANGAN PANGGILAN TES PT PLN (Persero) | CAREER DAYS UGM 19', $message, 1, null, $attachment);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = RecruitmentSessionUser::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='recruitment-session-user-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
