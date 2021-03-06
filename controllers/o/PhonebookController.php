<?php
/**
 * PhonebookController
 * @var $this PhonebookController
 * @var $model SmsPhonebook
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Suggest
 *	Import
 *	Add
 *	Edit
 *	View
 *	Runaction
 *	Delete
 *	Status
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 17:31 WIB
 * @link https://github.com/ommu/ommu-sms
 *
 *----------------------------------------------------------------------------------------------------------
 */

class PhonebookController extends Controller
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
				$arrThemes = $this->currentTemplate('admin');
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
				'actions'=>array('manage','suggest','import','add','edit','view','runaction','delete','status'),
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
		if(Yii::app()->user->level == 1 && Yii::app()->user->id == 1) {
			$criteria = new CDbCriteria;
			$model = SmsPhonebook::model()->findAll($criteria);
			foreach($model as $key => $val) {
				$model = SmsPhonebook::model()->findByPk($val->phonebook_id);
				$model->phonebook_nomor = SmsPhonebook::setPhoneNumber($model->phonebook_nomor);
				$model->save();
			}
		}
			
		$this->redirect(array('manage'));
	}	

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new SmsPhonebook('search');
		$model->unsetAttributes();	// clear any default values
		if(isset($_GET['SmsPhonebook'])) {
			$model->attributes=$_GET['SmsPhonebook'];
		}

		$columns = $model->getGridColumn($this->gridColumnTemp());

		$this->pageTitle = 'Sms Phonebooks Manage';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage', array(
			'model'=>$model,
			'columns' => $columns,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSuggest($limit=15) 
	{
		if(Yii::app()->getRequest()->getParam('term')) {
			$criteria = new CDbCriteria;
			$criteria->select = "phonebook_id, phonebook_nomor, phonebook_name";
			
			if(isset($_GET['group'])) {
				$criteria->with = array(
					'group' => array(
						'alias' => 'b',
					),
				);
				//$criteria->condition = 't.status=:status AND (t.phonebook_nomor LIKE :number OR t.phonebook_name LIKE :name) AND b.group_id=:group AND b.group_id IS NULL';
				$criteria->condition = 'status=:status AND phonebook_nomor LIKE :number OR phonebook_name LIKE :name';
				$criteria->params = array(
					':status' => 1,
					':number' => '%' . strtolower(SmsPhonebook::setPhoneNumber(Yii::app()->getRequest()->getParam('term'))) . '%',
					':name' => '%' . strtolower(Yii::app()->getRequest()->getParam('term')) . '%',
					//':group' => $_GET['group'],
				);
				
			} else {
				$criteria->condition = 'status=:status AND phonebook_nomor LIKE :number OR phonebook_name LIKE :name';
				$criteria->params = array(
					':status' => 1,
					':number' => '%' . strtolower(SmsPhonebook::setPhoneNumber(Yii::app()->getRequest()->getParam('term'))) . '%',
					':name' => '%' . strtolower(Yii::app()->getRequest()->getParam('term')) . '%',
				);
			}
			$criteria->limit = $limit;
			$criteria->order = "t.phonebook_id ASC";
			$model = SmsPhonebook::model()->findAll($criteria);

			if($model) {
				foreach($model as $items) {
					$contact = $items->phonebook_name != '' ? $items->phonebook_name." (".$items->phonebook_nomor.")" : $items->phonebook_nomor;
					if(isset($_GET['group'])) {
						$result[] = array('id' => $items->phonebook_id, 'value' => $contact);						
					} else {
						$result[] = array('id' => $items->phonebook_nomor, 'value' => $contact);							
					}
				}
			} else {
				if(!isset($_GET['group']))
					$result[] = array('id' => Yii::app()->getRequest()->getParam('term'), 'value' => ucwords(Yii::app()->getRequest()->getParam('term')));
			}
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionImport() 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		$sms_path = 'public/sms';
		if(!file_exists($sms_path)) {
			mkdir($sms_path, 0755, true);

			// Add File in User Folder (index.php)
			$newFile = $sms_path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
		} else
			@chmod($sms_path, 0755, true);
		
		$error = array();
		
		if(isset($_FILES['phonebookExcel'])) {
			$fileName = CUploadedFile::getInstanceByName('phonebookExcel');
			if(in_array(strtolower($fileName->extensionName), array('xls','xlsx'))) {
				$file = time().'_'.$this->urlTitle(date('d-m-Y H:i:s')).'_'.$this->urlTitle(Yii::app()->user->displayname).'.'.strtolower($fileName->extensionName);
				if($fileName->saveAs($sms_path.'/'.$file)) {
					Yii::import('ext.php-excel-reader.OExcelReader');
					$xls = new OExcelReader($sms_path.'/'.$file);
					
					for ($row = 2; $row <= $xls->sheets[0]['numRows']; $row++) {
						$no						= trim($xls->sheets[0]['cells'][$row][1]);
						$phonebook_name			= ucfirst(strtolower(trim($xls->sheets[0]['cells'][$row][2])));
						$phonebook_nomor		= trim($xls->sheets[0]['cells'][$row][3]);
						
						SmsPhonebook::insertPhonebook($phonebook_nomor, $phonebook_name);
					}
					
					Yii::app()->user->setFlash('success', 'Import Excell Success.');
					$this->redirect(array('manage'));
					
				} else {
					Yii::app()->user->setFlash('error', 'Gagal menyimpan file.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'Hanya file .xls dan .xlsx yang dibolehkan.');
			}
		}

		ob_end_flush();
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'Import Phonebook';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_import', array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new SmsPhonebook;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SmsPhonebook'])) {
			$model->attributes=$_POST['SmsPhonebook'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-sms-phonebook',
							'msg' => '<div class="errorSummary success"><strong>SmsPhonebook success created.</strong></div>',
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

		$this->pageTitle = 'Create Sms Phonebooks';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add', array(
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

		if(isset($_POST['SmsPhonebook'])) {
			$model->attributes=$_POST['SmsPhonebook'];
			
			if(!$model->getErrors())
				$phonebook_nomor = $model->phonebook_nomor;
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($phonebook_nomor != $model->phonebook_nomor)
						$model->phonebook_nomor = SmsPhonebook::setPhoneNumber($model->phonebook_nomor);
						
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-sms-phonebook',
							'msg' => '<div class="errorSummary success"><strong>SmsPhonebook success updated.</strong></div>',
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

		$this->pageTitle = 'Update Sms Phonebooks';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit', array(
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
		$this->dialogWidth = 500;

		$this->pageTitle = 'View Sms Phonebooks';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view', array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunaction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = Yii::app()->getRequest()->getParam('action');

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				SmsPhonebook::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				SmsPhonebook::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				SmsPhonebook::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				SmsPhonebook::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!Yii::app()->getRequest()->getParam('ajax')) {
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
			if($model->delete()) {
				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage'),
					'id' => 'partial-sms-phonebook',
					'msg' => '<div class="errorSummary success"><strong>SmsPhonebook success deleted.</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
			$this->dialogWidth = 350;

			$this->pageTitle = 'SmsPhonebook Delete.';
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
	public function actionStatus($id) 
	{
		$model=$this->loadModel($id);
		
		if($model->status == 1) {
			$title = 'Block';
			$replace = 0;
		} else {
			$title = 'Enable';
			$replace = 1;
		}

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			if(isset($id)) {
				//change value active or status
				$model->status = $replace;

				if($model->update()) {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-sms-phonebook',
						'msg' => '<div class="errorSummary success"><strong>SmsPhonebook success published.</strong></div>',
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
			$this->render('admin_status', array(
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
		$model = SmsPhonebook::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sms-phonebook-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
