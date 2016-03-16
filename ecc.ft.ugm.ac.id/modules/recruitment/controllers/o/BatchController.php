<?php
/**
 * BatchController
 * @var $this BatchController
 * @var $model RecruitmentSessions
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Manage
 *	Import
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
 * @created date 8 March 2016, 12:04 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class BatchController extends Controller
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
				'actions'=>array('manage','import','add','edit','view','runaction','delete','publish'),
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
	public function actionImport() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$path = 'public/recruitment/batch_excel';

		// Generate path directory
		if(!file_exists($path)) {
			@mkdir($path, 0755, true);

			// Add File in Article Folder (index.php)
			$newFile = $path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
		} else
			@chmod($path, 0755, true);
		
		$error = array();
		
		if(isset($_GET['id'])) {
			$sessionId = $_GET['id'];
			$url = Yii::app()->controller->createUrl('edit',array('id'=>$_GET['id']));			
		} else {
			$sessionId = $_POST['sessionsId'];
			$url = Yii::app()->controller->createUrl('manage');
		}
		$model = RecruitmentSessions::getInfo($sessionId);
		
		if(isset($_FILES['usersExcel'])) {
			$fileName = CUploadedFile::getInstanceByName('usersExcel');
			if(in_array(strtolower($fileName->extensionName), array('xls','xlsx')) && $sessionId != '') {				
				$file = time().'_'.Utility::getUrlTitle($model->session_name." ".$model->viewBatch->session_name." ".$model->recruitment->event_name).'.'.strtolower($fileName->extensionName);
				if($fileName->saveAs($path.'/'.$file)) {
					Yii::import('ext.excel_reader.OExcelReader');
					$xls = new OExcelReader($path.'/'.$file);
					
					for ($row = 2; $row <= $xls->sheets[0]['numRows']; $row++) {
						if($model->recruitment->event_type == 1) {
							$no				= trim($xls->sheets[0]['cells'][$row][1]);
							$test_number	= strtolower(trim($xls->sheets[0]['cells'][$row][2]));
							$password		= trim($xls->sheets[0]['cells'][$row][3]);
							$email			= strtolower(trim($xls->sheets[0]['cells'][$row][4]));
							$displayname	= trim($xls->sheets[0]['cells'][$row][5]);
							$major			= trim($xls->sheets[0]['cells'][$row][6]);
							$session_seat	= strtoupper(trim($xls->sheets[0]['cells'][$row][7]));
							//echo $no.' '.$test_number.' '.$password.' '.$email.' '.$displayname.' '.$major.' '.$session_seat;
							
							$user = RecruitmentUsers::model()->findByAttributes(array('email' => strtolower($email)), array(
								'select' => 'user_id, email',
							));
							if($user == null)
								$userId = RecruitmentUsers::insertUser($email, $password, $displayname, $major);
							else
								$userId = $user->user_id;
							
							$eventUser = RecruitmentEventUser::model()->find(array(
								'select'    => 'event_user_id, recruitment_id, test_number',
								'condition' => 'recruitment_id= :recruitment AND test_number= :number',
								'params'    => array(
									':recruitment' => $model->recruitment_id,
									':number' => strtolower($test_number),
								),
							));
							//echo $model->recruitment_id.' '.$userId.' '.$test_number.' '.$password.' '.$major;
							if($eventUser == null)
								$eventUserId = RecruitmentEventUser::insertUser($model->recruitment_id, $userId, $test_number, $password);
							else
								$eventUserId = $eventUser->event_user_id;
							
							RecruitmentSessionUser::insertUser($userId, $eventUserId, $sessionId, $session_seat);
						}
					}
					
					Yii::app()->user->setFlash('success', 'Import Recruitment Sessions User Success.');
					$this->redirect(array('manage'));
					
				} else
					Yii::app()->user->setFlash('errorFile', 'Gagal menyimpan file.');
			} else {
				Yii::app()->user->setFlash('errorFile', 'Hanya file .xls dan .xlsx yang dibolehkan.');
				if($sessionId == '')
					Yii::app()->user->setFlash('errorSession', 'Recruitment Sessions cannot be blank.');
			}
		}

		ob_end_flush();
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = $url;
		$this->dialogWidth = 600;

		$this->pageTitle = 'Import Recruitment Sessions User';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_import',array(
			'model'=>$model,
			'sessionsFieldRender'=>isset($_GET['id']) ? true : false,
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
			$this->redirect(Yii::app()->createUrl('site/index'));
		else
			$batchId = $_GET['id'];
		
		$batch = $this->loadModel($batchId);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($batch);

		if(isset($_POST['RecruitmentSessions'])) {
			$batch->attributes=$_POST['RecruitmentSessions'];
			$batch->scenario = 'blastForm';
			
			if($batch->save()) {
				$criteria=new CDbCriteria;
				$criteria->compare('t.publish',1);
				$criteria->compare('t.session_id',$batchId);
				
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
						$session = new RecruitmentSessionUser();
						$attachment = $session->getPdf($val);
						if(SupportMailSetting::sendEmail($val->user->email, $val->user->displayname, $batch->blasting_subject, $message, 1, null, $attachment)) {
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
				RecruitmentSessions::model()->updateByPk($batchId, array('blasting_status'=>1));
		
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
			'batch'=>$batch,
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
			$model->scenario = 'batchForm';
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('edit', array('id'=>$model->session_id)),
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
			$model->scenario = 'batchForm';

			/* 
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
							'msg' => '<div class="errorSummary success"><strong>RecruitmentSessions success updated.</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			*/
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'RecruitmentSessions success updated.');
				$this->redirect(array('manage'));
			}
		}

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
