<?php
/**
 * Recruitments
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:47 WIB
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
 * This is the model class for table "ommu_recruitments".
 *
 * The followings are the available columns in table 'ommu_recruitments':
 * @property string $recruitment_id
 * @property integer $publish
 * @property string $event_name
 * @property string $event_desc
 * @property integer $event_type
 * @property integer $event_logo
 * @property string $start_date
 * @property string $finish_date
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitmentEventUser[] $ommuRecruitmentEventUsers
 * @property OmmuRecruitmentSessions[] $ommuRecruitmentSessions
 */
class Recruitments extends CActiveRecord
{
	public $defaultColumns = array();
	public $permanent;
	public $oldEventLogo;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recruitments the static model class
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
		return 'ommu_recruitments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, event_name, event_desc, event_type, start_date, finish_date', 'required'),
			array('publish, event_type,
				permanent', 'numerical', 'integerOnly'=>true),
			array('event_name', 'length', 'max'=>32),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('event_logo, start_date, finish_date, 
				permanent, oldEventLogo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('recruitment_id, publish, event_name, event_desc, event_type, event_logo, start_date, finish_date, creation_date, creation_id, modified_date, modified_id,
				creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'eventUser' => array(self::HAS_MANY, 'RecruitmentEventUser', 'recruitment_id'),
			'sessionUser' => array(self::HAS_MANY, 'RecruitmentSessionUser', 'recruitment_id'),
			'view' => array(self::BELONGS_TO, 'ViewRecruitments', 'recruitment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'recruitment_id' => 'Recruitment',
			'publish' => 'Publish',
			'event_name' => 'Event Name',
			'event_desc' => 'Event Desc',
			'event_type' => 'Event Type',
			'event_logo' => 'Event Logo',
			'start_date' => 'Start Date',
			'finish_date' => 'Finish Date',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'permanent' => 'Permanent',
			'oldEventLogo' => 'Old Event Logo',
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

		$criteria=new CDbCriteria;

		$criteria->compare('t.recruitment_id',strtolower($this->recruitment_id),true);
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
		$criteria->compare('t.event_name',strtolower($this->event_name),true);
		$criteria->compare('t.event_desc',strtolower($this->event_desc),true);
		$criteria->compare('t.event_type',$this->event_type);
		$criteria->compare('t.event_logo',$this->event_logo);
		if($this->start_date != null && !in_array($this->start_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.start_date)',date('Y-m-d', strtotime($this->start_date)));
		if($this->finish_date != null && !in_array($this->finish_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.finish_date)',date('Y-m-d', strtotime($this->finish_date)));
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
		);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['Recruitments_sort']))
			$criteria->order = 't.recruitment_id DESC';

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
			//$this->defaultColumns[] = 'recruitment_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'event_desc';
			$this->defaultColumns[] = 'event_type';
			$this->defaultColumns[] = 'event_logo';
			$this->defaultColumns[] = 'start_date';
			$this->defaultColumns[] = 'finish_date';
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
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'event_desc';
			$this->defaultColumns[] = array(
				'name' => 'event_logo',
				'value' => '$data->event_logo != "" ? CHtml::link($data->event_logo, Yii::app()->request->baseUrl.\'/public/recruitment/\'.$data->event_logo, array(\'target\' => \'_blank\')) : "-"',
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'event_type',
				'value' => '$data->event_type == 0 ? "Direct" : "Bundle"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>'Bundle',
					0=>'Direct',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => 'Sessions',
				'value' => 'CHtml::link($data->view->sessions." Session", Yii::app()->controller->createUrl("o/session/manage",array("recruitment"=>$data->recruitment_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => 'Batchs',
				'value' => 'CHtml::link($data->view->batchs." Batch", Yii::app()->controller->createUrl("o/batch/manage",array("recruitment"=>$data->recruitment_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'header' => 'Users',
				'value' => 'CHtml::link($data->view->users." User", Yii::app()->controller->createUrl("o/eventuser/manage",array("recruitment"=>$data->recruitment_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'start_date',
				'value' => 'Utility::dateFormat($data->start_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'start_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'start_date_filter',
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
			$this->defaultColumns[] = array(
				'name' => 'finish_date',
				'value' => '$data->finish_date != "1970-01-01" ? Utility::dateFormat($data->finish_date) : "Permanent"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'finish_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'finish_date_filter',
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
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->recruitment_id)), $data->publish, 1)',
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
	public static function getEvent($publish=null) {
		
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('t.publish',$publish);
		
		$model = self::model()->findAll($criteria);

		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->recruitment_id] = $val->event_name;
			}
			return $items;
		} else {
			return false;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;		
			else
				$this->modified_id = Yii::app()->user->id;
			
			if(in_array(date('Y-m-d', strtotime($this->finish_date)), array('00-00-0000','01-01-1970')))
				$this->permanent = 1;
			
			if($this->permanent == 1)
				$this->finish_date = '00-00-0000';
			
			if($this->permanent != 1 && ($this->start_date != '' && $this->finish_date != '') && (date('Y-m-d', strtotime($this->start_date)) >= date('Y-m-d', strtotime($this->finish_date))))
				$this->addError('finish_date', 'Finish Data tidak boleh lebih kecil dari Start Date');
				
			$this->oldEventLogo = $this->event_logo;			
			$logo = CUploadedFile::getInstance($this, 'event_logo');		
			if($logo->name != '') {
				$extension = pathinfo($logo->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('event_logo', 'The file "'.$logo->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->start_date = date('Y-m-d', strtotime($this->start_date));
			$this->finish_date = date('Y-m-d', strtotime($this->finish_date));
			
			//upload new logo
			$recruitment_path = "public/recruitment";
			$this->event_logo = CUploadedFile::getInstance($this, 'event_logo');
			if($this->event_logo instanceOf CUploadedFile) {
				$fileName = time().'_'.Utility::getUrlTitle($this->event_name).'.'.strtolower($this->event_logo->extensionName);
				if($this->event_logo->saveAs($recruitment_path.'/'.$fileName)) {
					//create thumb image
					Yii::import('ext.phpthumb.PhpThumbFactory');
					$pageImg = PhpThumbFactory::create($recruitment_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
					$pageImg->resize(400);
					$pageImg->save($recruitment_path.'/'.$fileName);
					
					if(!$this->isNewRecord && $this->oldEventLogo != '' && file_exists($recruitment_path.'/'.$this->oldEventLogo))
						rename($recruitment_path.'/'.$this->oldEventLogo, 'public/recruitment/verwijderen/'.$this->recruitment_id.'_'.$this->oldEventLogo);
					$this->event_logo = $fileName;
				}
			}
			
			if(!$this->isNewRecord && $this->event_logo == '')
				$this->event_logo = $this->oldEventLogo;
		}
		return true;
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete recruitment logo
		$recruitment_path = "public/recruitment";
		if($this->event_logo != '' && file_exists($recruitment_path.'/'.$this->event_logo))
			rename($recruitment_path.'/'.$this->event_logo, 'public/recruitment/verwijderen/'.$this->recruitment_id.'_'.$this->event_logo);
	}

}