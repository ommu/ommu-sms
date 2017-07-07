<?php
/**
 * GroupbookController
 * @var $this GroupbookController
 * @var $model SmsGroupPhonebook
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Suggest
 *	Manage
 *	Add
 *	Delete
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 18:28 WIB
 * @link https://github.com/ommu/mod-sms
 * @contact (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class GroupbookController extends Controller
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
				'actions'=>array('suggest'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','delete'),
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
	 * Lists all models.
	 */
	public function actionSuggest($group=null) 
	{
		if(Yii::app()->request->isAjaxRequest) {
			$model = SmsGroups::model()->findByPk($group);
			$items = array();
			if($model != null) {
				$phonebooks = $model->phonebooks;		
				if(!empty($phonebooks)) {
					foreach($phonebooks as $key => $val) {
						$items[] = $val->phonebook_id;
					}
				}
			}
				
			if(isset($_GET['term'])) {
				$criteria = new CDbCriteria;
				$criteria->select = "phonebook_id, status, phonebook_nomor, phonebook_name";
				$criteria->compare('phonebook_nomor', strtolower(trim($_GET['term'])), true);
				$criteria->compare('phonebook_name', strtolower(trim($_GET['term'])), true, 'OR');	
				$criteria->compare('status', 1);		
				if(!empty($phonebooks))
					$criteria->addNotInCondition('phonebook_id',$items);
				$criteria->order = "phonebook_name ASC";
				//print_r($criteria);
				$model = SmsPhonebook::model()->findAll($criteria);

				if($model) {
					foreach($model as $items) {
						if($items->phonebook_name && $items->phonebook_nomor)
							$contact = Yii::t('phrase', '$phonebook_name ($phonebook_nomor)', array('$phonebook_name'=>$items->phonebook_name,'$phonebook_nomor'=>$items->phonebook_nomor));
						else
							$contact = $items->phonebook_name ? $items->phonebook_name : $items->phonebook_nomor;
						$result[] = array(
							'id' => $items->phonebook_id, 
							'value' => $contact,
						);
					}
				}
			}
			echo CJSON::encode($result);
			Yii::app()->end();
			
		} else
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new SmsGroupPhonebook('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SmsGroupPhonebook'])) {
			$model->attributes=$_GET['SmsGroupPhonebook'];
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

		$this->pageTitle = 'Sms Group Phonebooks Manage';
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
		$model=new SmsGroupPhonebook;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['group_id'], $_POST['phonebook_id'])) {
			$model->group_id = $_POST['group_id'];
			$model->phonebook_id = $_POST['phonebook_id'];

			if($model->save()) {
				if(isset($_GET['type']) && $_GET['type'] == 'sms')
					$url = Yii::app()->controller->createUrl('delete',array('id'=>$model->id,'type'=>'sms'));
				else 
					$url = Yii::app()->controller->createUrl('delete',array('id'=>$model->id));
				if($model->phonebook->phonebook_name && $model->phonebook->phonebook_nomor)
					$contact = Yii::t('phrase', '$phonebook_name ($phonebook_nomor)', array('$phonebook_name'=>$model->phonebook->phonebook_name,'$phonebook_nomor'=>$model->phonebook->phonebook_nomor));
				else
					$contact = $model->phonebook->phonebook_name ? $model->phonebook->phonebook_name : $model->phonebook->phonebook_nomor;
				echo CJSON::encode(array(
					'data' => '<div>'.$contact.'<a href="'.$url.'" title="'.Yii::t('phrase', 'Delete').'">'.Yii::t('phrase', 'Delete').'</a></div>',
				));
			}
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
				if(isset($_GET['type']) && $_GET['type'] == 'sms') {
					echo CJSON::encode(array(
						'type' => 4,
					));
				} else {
					echo CJSON::encode(array(
						'type' => 5,
						'get' => Yii::app()->controller->createUrl('manage'),
						'id' => 'partial-sms-group-phonebook',
						'msg' => '<div class="errorSummary success"><strong>SmsGroupPhonebook success deleted.</strong></div>',
					));
				}
			}

		} else {
			$this->dialogDetail = true;
			if(isset($_GET['type']) && $_GET['type'] == 'sms')
				$url = Yii::app()->controller->createUrl('o/group/edit', array('id'=>$model->group_id));
			else
				$url = Yii::app()->controller->createUrl('manage');
			$this->dialogGroundUrl = $url;
			$this->dialogWidth = 350;

			$this->pageTitle = 'SmsGroupPhonebook Delete.';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = SmsGroupPhonebook::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sms-group-phonebook-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
