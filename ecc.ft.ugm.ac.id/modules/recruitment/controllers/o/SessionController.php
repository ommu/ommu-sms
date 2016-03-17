<?php
/**
 * SessionController
 * @var $this SessionController
 * @var $model RecruitmentSessions
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Blast
 *	Add
 *	Edit
 *	View
 *	RunAction
 *	Delete
 *	Publish
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:52 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SessionController extends Controller
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
				'actions'=>array('manage','blast','add','edit','view','runaction','delete','publish'),
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
		$model=new RecruitmentSessions('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecruitmentSessions'])) {
			$model->attributes=$_GET['RecruitmentSessions'];
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

		$this->pageTitle = 'Recruitment Sessions Manage';
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
	public function actionBlast() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		if(!isset($_GET['id']))
			$this->redirect(Yii::app()->createUrl('admin/index'));
		else
			$sessionId = $_GET['id'];
		
		$session = $this->loadModel($sessionId);
		if($session->parent_id != 0)
			$this->redirect(Yii::app()->createUrl('admin/index'));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($session);

		if(isset($_POST['RecruitmentSessions'])) {
			$session->attributes=$_POST['RecruitmentSessions'];
			$session->scenario = 'blastForm';
			
			if($session->save()) {
				$criteria=new CDbCriteria;
				$criteria->compare('t.publish',1);
				if($session->parent_id == 0) {
					$batch = RecruitmentSessions::model()->findAll(array(
						'condition' => 'publish = :publish AND parent_id = :parent',
						'params' => array(
							':publish' => 1,
							':parent' => $sessionId,
						),
					));
					$items = array();
					if($batch != null) {
						foreach($batch as $key => $val)
							$items[] = $val->session_id;
					}
					$criteria->addInCondition('t.session_id',$items);
				}
				
				$model = RecruitmentSessionUser::model()->findAll($criteria);
				if($model != null) {
					$i = 0;
					foreach($model as $key => $val) {
						$i++;
						$search = array(
							'{$baseURL}', 
							'{$displayname}', '{$test_number}', '{$major}',
							'{$batch_day}', '{$batch_data}','{$batch_month}', '{$batch_year}',
							'{$session_date}', '{$session_time_start}', '{$session_time_finish}');
						$replace = array(
							Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl,
							$val->user->displayname, strtoupper($val->eventUser->test_number), $val->user->major,
							Utility::getLocalDayName($val->session->session_date, false), date('d', strtotime($val->session->session_date)), Utility::getLocalMonthName($val->session->session_date), date('Y', strtotime($val->session->session_date)),
							$val->session->session_name, $val->session->session_time_start, $val->session->session_time_finish);
						$template = 'pln_cdugm19_mail';
						$message = file_get_contents(YiiBase::getPathOfAlias('webroot.externals.recruitment.template').'/'.$template.'.php');
						$message = str_ireplace($search, $replace, $message);
						$sessions = new RecruitmentSessionUser();
						$attachment = $sessions->getPdf($val);
						if(SupportMailSetting::sendEmail($val->user->email, $val->user->displayname, $session->blasting_subject, $message, 1, null, $attachment)) {
							RecruitmentSessionUser::model()->updateByPk($val->id, array(
								'sendemail_status'=>1, 
								'sendemail_id'=>Yii::app()->user->id,
							));
						}
						
						if($i%50 == 0) {
							$event = $val->session->session_name.' '.$val->session->viewBatch->session_name.' '.$val->session->recruitment->event_name;
							SupportMailSetting::sendEmail(SupportMailSetting::getInfo(1,'mail_contact'), 'Ommu Support', 'Send Email Blast: '.$event.' ('.$i.')', $event, 1, null, $attachment);
						}
					}
				}
				RecruitmentSessions::model()->updateByPk($sessionId, array('blasting_status'=>1));
		
				Yii::app()->user->setFlash('success', 'Blasting success.');
				$this->redirect(array('manage'));
			}			
		}
		
		ob_end_flush();
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Blasting';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_blast',array(
			'session'=>$session,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new RecruitmentSessions;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['RecruitmentSessions'])) {
			$model->attributes=$_POST['RecruitmentSessions'];
			$model->scenario = 'sessionForm';
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-recruitment-sessions',
							'msg' => '<div class="errorSummary success"><strong>RecruitmentSessions success created.</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Create Recruitment Sessions';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['RecruitmentSessions'])) {
			$model->attributes=$_POST['RecruitmentSessions'];
			$model->scenario = 'sessionForm';
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-recruitment-sessions',
							'msg' => '<div class="errorSummary success"><strong>RecruitmentSessions success created.</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Update Recruitment Sessions';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit',array(
			'model'=>$model,
		));
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

		$this->pageTitle = 'View Recruitment Sessions';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view',array(
			'model'=>$model,
		));
	}	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunAction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = $_GET['action'];

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				RecruitmentSessions::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				RecruitmentSessions::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				RecruitmentSessions::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				RecruitmentSessions::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				if($model->delete()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-recruitment-sessions',
						'msg' => '<div class="errorSummary success"><strong>RecruitmentSessions success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'RecruitmentSessions Delete.';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id) 
	{
		$model=$this->loadModel($id);
		
		if($model->publish == 1) {
			$title = Phrase::trans(276,0);
			$replace = 0;
		} else {
			$title = Phrase::trans(275,0);
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or publish
				$model->publish = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-recruitment-sessions',
						'msg' => '<div class="errorSummary success"><strong>RecruitmentSessions success published.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = $title;
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_publish',array(
				'title'=>$title,
				'model'=>$model,
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
		$model = RecruitmentSessions::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='recruitment-sessions-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
