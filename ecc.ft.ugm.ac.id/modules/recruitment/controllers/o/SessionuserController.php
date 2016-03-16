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
 *	SendEmail
 *	PrintCard
 *	DocumentTest
 *	EntryCard
 *	AbsenRecap
 *	AbsenReset
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
				'actions'=>array('manage','sendemail','printcard','documenttest','entrycard','absenrecap','absenreset','add','edit','runaction','delete','publish'),
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
		$model=new RecruitmentSessionUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RecruitmentSessionUser'])) {
			$model->attributes=$_GET['RecruitmentSessionUser'];
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
                
		$this->pageTitle = 'Recruitment Session Users';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('/o/session_user/admin_manage',array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSendEmail($id) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		$model=$this->loadModel($id);
		
		$search = array(
			'{$baseURL}', 
			'{$displayname}', '{$test_number}', '{$major}',
			'{$model_day}', '{$model_data}','{$model_month}', '{$model_year}',
			'{$session_date}', '{$session_time_start}', '{$session_time_finish}');
		$replace = array(
			Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl,
			$model->user->displayname, strtoupper($model->eventUser->test_number), $model->user->major,
			Utility::getLocalDayName($model->session->session_date, false), date('d', strtotime($model->session->session_date)), Utility::getLocalMonthName($model->session->session_date), date('Y', strtotime($model->session->session_date)),
			$model->session->session_name, $model->session->session_time_start, $model->session->session_time_finish);
		$template = 'pln_cdugm19_mail';
		$message = file_get_contents(YiiBase::getPathOfAlias('webroot.externals.recruitment.template').'/'.$template.'.php');
		$message = str_ireplace($search, $replace, $message);
		$session = new RecruitmentSessionUser();
		$attachment = $session->getPdf($model);
		if(SupportMailSetting::sendEmail($model->user->email, $model->user->displayname, $model->session->blasting_subject, $message, 1, null, $attachment)) {
			RecruitmentSessionUser::model()->updateByPk($model->id, array(
				'sendemail_status'=>1, 
				'sendemail_id'=>Yii::app()->user->id,
			));
		}
		
		Yii::app()->user->setFlash('success', 'Send Email success.');
		$this->redirect(Yii::app()->controller->createUrl('manage', array('session'=>$model->session_id)));
		
		ob_end_flush();
	}

	/**
	 * Manages all models.
	 */
	public function actionPrintCard($id) 
	{
		ini_set('max_execution_time', 0);
		ob_start();			
		$model=$this->loadModel($id);
		
		echo $model->getPdf($model, true);
		RecruitmentSessionUser::model()->updateByPk($model->id, array(
			'printcard_date'=>date('Y-m-d H:i:s'), 
			'printcard_id'=>Yii::app()->user->id,
		));
		
		ob_end_flush();
	}

	/**
	 * Manages all models.
	 */
	public function actionDocumentTest($session) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$batch = RecruitmentSessions::model()->findByPk($session);
		if(isset($_GET['reset'])) {
			if(RecruitmentSessions::model()->updateByPk($session, array('documents'=>'')))
				$this->redirect(Yii::app()->controller->createUrl('documenttest', array('session'=>$session)));
		}
			
		if($batch->parent_id == 0)
			$itemCount = $batch->view->users;
		else
			$itemCount = $batch->viewBatch->users;			

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($batch);

		if(isset($_POST['RecruitmentSessions'])) {
			$batch->attributes=$_POST['RecruitmentSessions'];
			$batch->scenario = 'documentTestForm';
			
			if($batch->validate()) {
				$pageitem = $batch->pageItem;
				$pageSize = $pageitem >= $itemCount ? $itemCount : $pageitem ;
				$pageCount = $itemCount >= $pageSize ? ($itemCount%$pageSize === 0 ? (int)($itemCount/$pageSize) : (int)($itemCount/$pageSize)+1) : 1;
				
				$template = 'document_test';
				$path = YiiBase::getPathOfAlias('webroot.public.recruitment.document_test');
				
				$documentArray = array();
				for ($i = 1; $i <= $pageCount; $i++) {
					$offset = (int)($i-1)*$pageSize;
				
					$criteria=new CDbCriteria;
					$criteria->compare('t.publish',1);
					if($batch->parent_id == 0) {
						$subBatch = RecruitmentSessions::model()->findAll(array(
							'condition' => 'publish = :publish AND parent_id = :parent',
							'params' => array(
								':publish' => 1,
								':parent' => $session,
							),
						));
						$items = array();
						if($subBatch != null) {
							foreach($subBatch as $key => $val)
								$items[] = $val->session_id;
						}
						$criteria->addInCondition('t.session_id',$items);
						
					} else					
						$criteria->compare('t.session_id',$session);
					
					$criteria->limit = $pageSize;
					$criteria->offset = $offset;
					$model = RecruitmentSessionUser::model()->findAll($criteria);
					
					$documentName = Utility::getUrlTitle('document_test_'.$batch->session_name.' '.$batch->viewBatch->session_name.' '.$batch->recruitment->event_name.'_'.str_pad($i, 3, '0', STR_PAD_LEFT));
					$document = new RecruitmentSessionUser();
					$fileName = $document->getPdf($model, false, $template, $path, $documentName, 'L', false);
					array_push($documentArray, $fileName);
				}
				RecruitmentSessions::model()->updateByPk($session, array(
					'documents'=>implode(',', $documentArray),
					'document_id'=>Yii::app()->user->id,
				));
				
				Yii::app()->user->setFlash('success', 'Generate Document Test Success.');
				$this->redirect(Yii::app()->controller->createUrl('documenttest', array('session'=>$session)));
			}
		}
		
		ob_end_flush();
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('session'=>$session));
		$this->dialogWidth = 600;

		$this->pageTitle = 'Download Document Test';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('/o/session_user/admin_document',array(
			'batch'=>$batch,
			'itemCount'=>$itemCount,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionEntryCard($session) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$batch = RecruitmentSessions::model()->findByPk($session);
		
		$criteria=new CDbCriteria;
		$criteria->compare('t.publish',1);
		$criteria->compare('t.session_id',$session);
		//$criteria->limit = 4;
		$model = RecruitmentSessionUser::model()->findAll($criteria);
		
		$template = 'entry_card';
		$path = YiiBase::getPathOfAlias('webroot.public.recruitment.document_entrycard');
		$documentName = Utility::getUrlTitle('entrycard_'.$batch->session_name.' '.$batch->viewBatch->session_name.' '.$batch->recruitment->event_name);		
		$document = new RecruitmentSessionUser();
		echo $document->getPdf($model, true, $template, $path, $documentName);
		
		ob_end_flush();
	}

	/**
	 * Manages all models.
	 */
	public function actionAbsenRecap($session) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$batch = RecruitmentSessions::model()->findByPk($session);
		
		$criteria=new CDbCriteria;
		$criteria->compare('t.publish',1);
		if($batch->parent_id == 0) {
			$subBatch = RecruitmentSessions::model()->findAll(array(
				'condition' => 'publish = :publish AND parent_id = :parent',
				'params' => array(
					':publish' => 1,
					':parent' => $session,
				),
			));
			$items = array();
			if($subBatch != null) {
				foreach($subBatch as $key => $val)
					$items[] = $val->session_id;
			}
			$criteria->addInCondition('t.session_id',$items);
			
		} else					
			$criteria->compare('t.session_id',$session);
		
		//$criteria->limit = 4;
		$model = RecruitmentSessionUser::model()->findAll($criteria);
		
		$template = 'absen_recap';
		$path = YiiBase::getPathOfAlias('webroot.public.recruitment.document_test');		
		$documentName = Utility::getUrlTitle('absen_recap_'.$batch->session_name.' '.$batch->viewBatch->session_name.' '.$batch->recruitment->event_name);
		$document = new RecruitmentSessionUser();
		echo $document->getPdf($model, true, $template, $path, $documentName);
		
		ob_end_flush();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAbsenReset($session) 
	{
		$model=RecruitmentSessions::model()->findByPk($session);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($session)) {				
				$criteria=new CDbCriteria;
				$criteria->compare('t.publish',1);
				if($model->parent_id == 0) {
					$batch = RecruitmentSessions::model()->findAll(array(
						'condition' => 'publish = :publish AND parent_id = :parent',
						'params' => array(
							':publish' => 1,
							':parent' => $session,
						),
					));
					$items = array();
					if($batch != null) {
						foreach($batch as $key => $val)
							$items[] = $val->session_id;
					}
					$criteria->addInCondition('t.session_id',$items);
					
				} else					
					$criteria->compare('t.session_id',$session);
				
				$user = RecruitmentSessionUser::model()->findAll($criteria);
				foreach($user as $key => $val)
					RecruitmentSessionUser::model()->updateByPk($val->id, array('scanner_status'=>0,'scanner_field'=>0));
				
				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage'),
					'id' => 'partial-recruitment-session-user',
					'msg' => '<div class="errorSummary success"><strong>RecruitmentSessionUser success absen reset.</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('session'=>$session));
			$this->dialogWidth = 350;

			$this->pageTitle = 'RecruitmentSessionUser Absen Reset.';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('/o/session_user/admin_absen_reset');
		}
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new RecruitmentSessionUser;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['RecruitmentSessionUser'])) {
			$model->attributes=$_POST['RecruitmentSessionUser'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-recruitment-session-user',
							'msg' => '<div class="errorSummary success"><strong>RecruitmentSessionUser success created.</strong></div>',
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

		$this->pageTitle = 'Create Recruitment Session Users';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('/o/session_user/admin_add',array(
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

		if(isset($_POST['RecruitmentSessionUser'])) {
			$model->attributes=$_POST['RecruitmentSessionUser'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-recruitment-session-user',
							'msg' => '<div class="errorSummary success"><strong>RecruitmentSessionUser success updated.</strong></div>',
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

		$this->pageTitle = 'Update Recruitment Session Users';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('/o/session_user/admin_edit',array(
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
				RecruitmentSessionUser::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				RecruitmentSessionUser::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				RecruitmentSessionUser::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				RecruitmentSessionUser::model()->deleteAll($criteria);
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
						'id' => 'partial-recruitment-session-user',
						'msg' => '<div class="errorSummary success"><strong>RecruitmentSessionUser success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'RecruitmentSessionUser Delete.';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('/o/session_user/admin_delete');
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
						'id' => 'partial-recruitment-session-user',
						'msg' => '<div class="errorSummary success"><strong>RecruitmentSessionUser success published.</strong></div>',
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
			$this->render('/o/session_user/admin_publish',array(
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
