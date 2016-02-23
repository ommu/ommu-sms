<?php
/**
 * SiteController
 * @var $this SiteController
 * @var $model Visits
 * @var $form CActiveForm
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
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SiteController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
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
		Yii::import('application.components.plugin.Calendar');
		
		if(isset($_GET)) {
			$d = date('d', strtotime($_GET['cdate'].'-01'));
			$m = date('m', strtotime($_GET['cdate'].'-01'));
			$Y = date('Y', strtotime($_GET['cdate'].'-01'));
			$today = date('Y-m-d', strtotime($_GET['cdate'].'-01'));
		} else {
			$d = date('d');
			$m = date('m');
			$Y = date('Y');
			$today = date('Y-m-d');
		}
		
		$criteria=new CDbCriteria;
		$criteria->condition = 'status = :status AND ((YEAR(`start_date`)=:year AND MONTH(`start_date`)=:month) OR (YEAR(`finish_date`)=:year AND MONTH(`finish_date`)=:month))';
		$criteria->params = array(
			':status'=>1,
			':year'=>$Y,
			':month'=>$m,
		);
		$criteria->order = 'start_date ASC';
		$model = Visits::model()->findAll($criteria);
		
		$eventArray = [];
		$days = cal_days_in_month(CAL_GREGORIAN,$m,$Y);
		$i=1;
		for($i; $i<=$days; $i++) {
			$eventData = $Y.'-'.$m.'-'.$i;
			$eventData = date('Y-m-d', strtotime($eventData));
		
			$criteriaEventByDay=new CDbCriteria;
			$criteriaEventByDay->condition = 'status = :status AND :date BETWEEN `start_date` AND `finish_date`';
			$criteriaEventByDay->params = array(
				':status'=>1,
				':date'=>$eventData,
			);
			//$criteriaEventByDay->order = 'creation_date DESC';
			$eventModel = Visits::model()->findAll($criteriaEventByDay);
			$data = '';
			if($eventModel != null) {
				$eventArray[$eventData] = '';
				foreach($eventModel as $key => $val) {
					$data[] .= $val->guest_TO->organization == 1 ? ($val->guest_TO->author_id != 0 ? $val->guest_TO->organization_name." (".$val->guest_TO->author_TO->name.")" : $val->guest_TO->organization_name) : $val->guest_TO->author_TO->name;
				}
				$eventArray[$eventData] = $data;
			}
		}
		
		$cal = new Calendar($d, $m, $Y, $today);
		
		/**** OPTIONAL METHODS ****/
		$cal->setDate($today); //Set starting date
		$cal->setBasePath(Yii::app()->controller->createUrl('index')); // Base path for navigation URLs
		$cal->showNav(true); // Show or hide navigation
		$cal->setView(null); //'day' or 'week' or null
		$cal->setStartEndHours(8,20); // Set the hour range for day and week view
		$cal->setTimeClass('ctime'); //Class Name for times column on day and week views
		$cal->setEventsWrap(array('<p style="display: none;">', '</p>')); // Set the event's content wrapper
		$cal->setDayWrap(array('<div>','</div>')); //Set the day's number wrapper
		$cal->setNextIcon('>>'); //Can also be html: <i class='fa fa-chevron-right'></i>
		$cal->setPrevIcon('<<'); // Same as above
		$cal->setDayLabels(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')); //Label names for week days
		$cal->setMonthLabels(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')); //Month names
		$cal->setDateWrap(array('<div>','</div>')); //Set cell inner content wrapper
		$cal->setTableClass('table'); //Set the table's class name
		$cal->setHeadClass('table-header'); //Set top header's class name
		$cal->setNextClass('btn'); // Set next btn class name
		$cal->setPrevClass('btn'); // Set Prev btn class name
		$cal->setEvents($eventArray); // Receives the events array
		/**** END OPTIONAL METHODS ****/

		//echo $cal->generate(); // Return the calendar's html
		
		$this->adsSidebar = false;
		$this->pageTitleShow = true;
		$this->pageTitle = 'Jadwal Kunjungan';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('front_index', array(
			'cal'=>$cal,
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

		$this->pageTitle = 'View Visits';
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
		$model = Visits::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='visits-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
