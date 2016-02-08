<?php
/**
 * RequestController
 * @var $this RequestController
 * @var $model BookRequests * @var $form CActiveForm
 * Copyright (c) 2013, Ommu Platform (ommu.co). All rights reserved.
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	View
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class RequestController extends Controller
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
				'actions'=>array('index','view'),
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
		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish';
		$criteria->params = array(':publish'=>1);
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('BookRequests', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>8,
			),
		));
		
		$model=new BookRequests;
		$book=new BookMasters;
		$author=new OmmuAuthors;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['BookRequests'], $_POST['BookMasters'], $_POST['OmmuAuthors'])) {
			$model->attributes=$_POST['BookRequests'];
			$book->attributes=$_POST['BookMasters'];
			$book->scenario='request';
			$author->attributes=$_POST['OmmuAuthors'];
			
			$jsonError = CActiveForm::validate($model);
			$jsonErrorBook = CActiveForm::validate($book);
			$jsonErrorAuthor = CActiveForm::validate($author);
			
			if(strlen($jsonError) > 2 || strlen($jsonErrorBook) > 2 || strlen($jsonErrorAuthor) > 2) {
                $modelArray = json_decode($jsonError, true);
				$bookArray = json_decode($jsonErrorBook, true);
				$authorArray = json_decode($jsonErrorAuthor, true);
                $merge = array_merge_recursive($modelArray, $bookArray);
                $merge = array_merge_recursive($authorArray, $merge);
                $encode = json_encode($merge);
                echo $encode;

			} else {
				if(isset($_GET['enablesave']) && $_GET['enablesave'] == 1) {
					$authorModel = OmmuAuthors::model()->find(array(
						'select' => 'author_id, email',
						'condition' => 'publish = 1 AND email = :email',
						'params' => array(
							':email' => strtolower($author->email),
						),
					));
					if($authorModel != null) {
						$model->requester_id = $authorModel->author_id;
					} else {
						if($author->save())
							$model->requester_id = $author->author_id;
					}
					
					if($model->book_id == '') {
						$bookModel = BookMasters::model()->find(array(
							'select' => 'book_id, title',
							'condition' => 'publish = 1 AND title = :title',
							'params' => array(
								':title' => strtolower($model->book_input),
							),
						));
						if($bookModel != null) {
							$model->book_id = $bookModel->book_id;
							if($model->save()) {
								echo CJSON::encode(array(
									'type' => 5,
									'get' => Yii::app()->controller->createUrl('index'),
									'id' => 'partial-book-requests',
									'msg' => '<div class="errorSummary success"><strong>BookRequests success created.</strong></div>',
								));
							} else {
								print_r($model->getErrors());
							}
						} else {
							$book->title = $model->book_input;
							if($book->save()) {
								$model->book_id = $book->book_id;
								if($model->save()) {
									echo CJSON::encode(array(
										'type' => 5,
										'get' => Yii::app()->controller->createUrl('index'),
										'id' => 'partial-book-requests',
										'msg' => '<div class="errorSummary success"><strong>BookRequests success created.</strong></div>',
									));
								} else {
									print_r($model->getErrors());
								}
							} else {
								print_r($book->getErrors());
							}
						}
					} else {
						if($model->save()) {
							echo CJSON::encode(array(
								'type' => 5,
								'get' => Yii::app()->controller->createUrl('index'),
								'id' => 'partial-book-requests',
								'msg' => '<div class="errorSummary success"><strong>BookRequests success created.</strong></div>',
							));
						} else {
							print_r($model->getErrors());
						}
					}
				}
			}
			Yii::app()->end();
			
		} else {
			$this->pageTitleShow = true;
			$this->pageTitle = 'Usulan Buku';
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('front_index',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model,
				'book'=>$book,
				'author'=>$author,
			));
		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);

		$this->pageTitle = 'View Book Requests';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_view',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = BookRequests::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-requests-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
