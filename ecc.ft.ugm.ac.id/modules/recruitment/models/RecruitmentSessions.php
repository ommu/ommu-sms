<?php
/**
 * RecruitmentSessions
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:48 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_recruitment_sessions".
 *
 * The followings are the available columns in table 'ommu_recruitment_sessions':
 * @property string $session_id
 * @property integer $publish
 * @property string $recruitment_id
 * @property string $parent_id
 * @property string $session_name
 * @property string $session_info
 * @property string $session_code
 * @property string $session_date
 * @property string $session_time_start
 * @property string $session_time_finish
 * @property string $blasting_subject
 * @property integer $blasting_status
 * @property string $blasting_date
 * @property string $blasting_id
 * @property string $documents
 * @property string $document_date
 * @property integer $document_id
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitmentSessionUser[] $ommuRecruitmentSessionUsers
 * @property OmmuRecruitments $recruitment
 */
class RecruitmentSessions extends CActiveRecord
{
	public $defaultColumns = array();
	public $pageItem;
	
	// Variable Search
	public $recruitment_search;
	public $session_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecruitmentSessions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_recruitment_sessions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, session_name', 'required'),
			array('recruitment_id, session_info, session_code', 'required', 'on'=>'sessionForm'),
			array('parent_id', 'required', 'on'=>'batchForm'),
			array('blasting_subject', 'required', 'on'=>'blastForm'),
			array('
				pageItem', 'required', 'on'=>'documentTestForm'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('recruitment_id, parent_id, document_id, creation_id, modified_id', 'length', 'max'=>11),
			array('session_name, session_code', 'length', 'max'=>32),
			array('blasting_subject', 'length', 'max'=>64),
			array('session_date, session_time_start, session_time_finish, blasting_subject, blasting_status,
				pageItem', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_id, publish, recruitment_id, parent_id, session_name, session_info, session_code, session_date, session_time_start, session_time_finish, blasting_subject, blasting_status, blasting_date, blasting_id, documents, document_date, document_id, creation_date, creation_id, modified_date, modified_id,
				recruitment_search, session_search, creation_search, modified_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'recruitment' => array(self::BELONGS_TO, 'Recruitments', 'recruitment_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'view' => array(self::BELONGS_TO, 'ViewRecruitmentSessions', 'session_id'),
			'viewBatch' => array(self::BELONGS_TO, 'ViewRecruitmentSessionBatch', 'session_id'),
			'batch' => array(self::HAS_MANY, 'ViewRecruitmentSessionBatch', 'session_id'),
			'batchPublish' => array(self::HAS_MANY, 'ViewRecruitmentSessionBatch', 'session_id', 'condition'=>'publish=1'),
			'batchNotPublish' => array(self::HAS_MANY, 'ViewRecruitmentSessionBatch', 'session_id', 'condition'=>'publish=0'),
			'users' => array(self::HAS_MANY, 'RecruitmentSessionUser', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'session_id' => 'Session',
			'publish' => 'Publish',
			'recruitment_id' => 'Recruitment',
			'parent_id' => 'Parent',
			'session_name' => 'Session Name',
			'session_info' => 'Session Info',
			'session_code' => 'Session Code',
			'session_date' => 'Session Date',
			'session_time_start' => 'Time Start',
			'session_time_finish' => 'Time Finish',
			'blasting_subject' => 'Blasting Subject',
			'blasting_status' => 'Blasting',
			'blasting_date' => 'Blasting Date',
			'blasting_id' => 'Blasting',
			'documents' => 'Documents',
			'document_date' => 'Documents Date',
			'document_id' => 'Documents',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'pageItem' => 'Page Item',
			'recruitment_search' => 'Recruitment',
			'session_search' => 'Session',
			'creation_search' => 'Creation',
			'modified_search' => 'Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$controller = strtolower(Yii::app()->controller->id);

		$criteria=new CDbCriteria;

		$criteria->compare('t.session_id',strtolower($this->session_id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['recruitment']))
			$criteria->compare('t.recruitment_id',$_GET['recruitment']);
		else
			$criteria->compare('t.recruitment_id',$this->recruitment_id);
		if($controller == 'o/session') {
			$criteria->compare('t.parent_id',0);			
		} else {
			$criteria->addNotInCondition('t.parent_id',array(0));
			if(isset($_GET['parent']))
				$criteria->compare('t.parent_id',$_GET['parent']);
			else
				$criteria->compare('t.parent_id',$this->parent_id);
		}
		$criteria->compare('t.session_name',strtolower($this->session_name),true);
		$criteria->compare('t.session_info',strtolower($this->session_info),true);
		$criteria->compare('t.session_code',strtolower($this->session_code),true);
		if($this->session_date != null && !in_array($this->session_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.session_date)',date('Y-m-d', strtotime($this->session_date)));
		$criteria->compare('t.session_time_start',strtolower($this->session_time_start),true);
		$criteria->compare('t.session_time_finish',strtolower($this->session_time_finish),true);
		$criteria->compare('t.blasting_subject',strtolower($this->blasting_subject),true);
		$criteria->compare('t.blasting_status',strtolower($this->blasting_status),true);
		if($this->blasting_date != null && !in_array($this->blasting_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.blasting_date)',date('Y-m-d', strtotime($this->blasting_date)));
		if(isset($_GET['blasting']))
			$criteria->compare('t.blasting_id',$_GET['blasting']);
		else
			$criteria->compare('t.blasting_id',$this->blasting_id);
		$criteria->compare('t.documents',strtolower($this->documents),true);
		if($this->document_date != null && !in_array($this->document_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.document_date)',date('Y-m-d', strtotime($this->document_date)));
		if(isset($_GET['document']))
			$criteria->compare('t.document_id',$_GET['document']);
		else
			$criteria->compare('t.document_id',$this->document_id);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		
		// Custom Search
		$criteria->with = array(
			'recruitment' => array(
				'alias'=>'recruitment',
				'select'=>'event_name'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
			'view' => array(
				'alias'=>'view',
				//'select'=>'users'
			),
			'viewBatch' => array(
				'alias'=>'viewBatch',
				//'select'=>'users'
			),
		);
		$criteria->compare('recruitment.event_name',strtolower($this->recruitment_search), true);
		$criteria->compare('viewBatch.session_name',strtolower($this->session_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['RecruitmentSessions_sort']))
			$criteria->order = 't.session_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'session_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'recruitment_id';
			$this->defaultColumns[] = 'parent_id';
			$this->defaultColumns[] = 'session_name';
			$this->defaultColumns[] = 'session_info';
			$this->defaultColumns[] = 'session_code';
			$this->defaultColumns[] = 'session_date';
			$this->defaultColumns[] = 'session_time_start';
			$this->defaultColumns[] = 'session_time_finish';
			$this->defaultColumns[] = 'blasting_subject';
			$this->defaultColumns[] = 'blasting_status';
			$this->defaultColumns[] = 'blasting_date';
			$this->defaultColumns[] = 'blasting_id';
			$this->defaultColumns[] = 'documents';
			$this->defaultColumns[] = 'document_date';
			$this->defaultColumns[] = 'document_id';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$controller = strtolower(Yii::app()->controller->id);

			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'session_name';
			if($controller == 'o/session') {
				$this->defaultColumns[] = 'session_code';
			}
			if($controller == 'o/batch') {
				$this->defaultColumns[] = array(
					'name' => 'session_search',
					'value' => '$data->parent_id != 0 ? $data->viewBatch->session_name : "-"',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'recruitment_search',
				'value' => '$data->recruitment->event_name',
			);
			/*
			$this->defaultColumns[] = array(
				'name' => 'session_info',
				'value' => '$data->session_info',
				'type' => 'raw',
			);
			*/
			$this->defaultColumns[] = array(
				'name' => 'session_date',
				'value' => '!in_array($data->session_date, array("0000-00-00","1970-01-01")) ? Utility::dateFormat($data->session_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'session_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'session_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if($controller == 'o/batch') {
				$this->defaultColumns[] = array(
					'header' => 'Time',
					'value' => 'date("H:i", strtotime($data->session_time_start))." - ".date("H:i", strtotime($data->session_time_finish))',
				);				
			}
			if($controller == 'o/session') {
				$this->defaultColumns[] = array(
					'header' => 'Batchs',
					'value' => 'CHtml::link($data->view->batchs." Batch", Yii::app()->controller->createUrl("o/batch/manage",array("parent"=>$data->session_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
			if($controller == 'o/session') {
				$this->defaultColumns[] = array(
					'header' => 'Users',
					'value' => 'CHtml::link($data->view->users." User", Yii::app()->controller->createUrl("o/sessionuser/manage",array("session"=>$data->session_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			} else {
				$this->defaultColumns[] = array(
					'header' => 'Users',
					'value' => 'CHtml::link($data->viewBatch->users." User", Yii::app()->controller->createUrl("o/sessionuser/manage",array("session"=>$data->session_id)))',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);				
			}
			/*
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			*/
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'blasting_status',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("blast",array("id"=>$data->session_id)), $data->blasting_status, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->session_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

	/**
	 * Get Event
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getSession($parent=null, $publish=null, $type=null) {
		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('t.publish',$publish);
		if($parent != null) {
			if($parent == 'batch')
				$criteria->addNotInCondition('t.parent_id',array(0));
			else
				$criteria->compare('t.parent_id',$parent);
		}
		
		$model = self::model()->findAll($criteria);

		if($type == null) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val)
					$items[$val->session_id] = $val->recruitment->event_name.' ('.$val->session_name.')';
				return $items;
				
			} else
				return false;
			
		} else
			return $model;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		$controller = strtolower(Yii::app()->controller->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		if(parent::beforeValidate()) {
			$this->session_date = date('Y-m-d', strtotime($this->session_date));
			$this->session_time_start = date('H:i:s', strtotime($this->session_time_start));
			$this->session_time_finish = date('H:i:s', strtotime($this->session_time_finish));
			
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
			else {
				$this->modified_id = Yii::app()->user->id;
				if(in_array($currentAction, array('o/session/blast','o/batch/blast')))
					$this->blasting_id = Yii::app()->user->id;
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
		$controller = strtolower(Yii::app()->controller->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		if(!$this->isNewRecord) {
			$data = self::getSession($this->session_id, null, 'data');
			if($data != null) {
				foreach($data as $val) {
					$batch = self::model()->findByPk($val->session_id);
					$batch->session_date = $this->session_date;
					if($currentAction == 'o/session/blast') {
						if($val->blasting_subject == '')
							$batch->blasting_subject = $this->blasting_subject;
						$batch->blasting_status = 1;
					}
					$batch->save();
				}
			}
		}
		
		if($currentAction == 'o/batch/blast') {
			$data = self::model()->findAll(array(
				'condition'=> 'parent_id = :parent AND blasting_status = :blasting',
				'params'=>array(
					':parent'=>$this->parent_id,
					':blasting'=>0,
				),
			));
			if($data == null)
				self::model()->updateByPk($this->parent_id, array('blasting_subject'=>'Ommu Done', 'blasting_status'=>1));
		}
	}

}