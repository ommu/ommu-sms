<?php
/**
 * VisitGuest
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 12:57 WIB
 * @link https://github.com/oMMuCo
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
 * This is the model class for table "ommu_visit_guest".
 *
 * The followings are the available columns in table 'ommu_visit_guest':
 * @property string $guest_id
 * @property integer $status
 * @property string $author_id
 * @property string $start_date
 * @property string $finish_date
 * @property integer $organization
 * @property string $organization_name
 * @property string $organization_address
 * @property string $organization_phone
 * @property integer $visitor
 * @property string $messages
 * @property string $message_file
 * @property string $message_reply
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuVisits[] $ommuVisits
 */
class VisitGuest extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_file;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisitGuest the static model class
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
		return 'ommu_visit_guest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date, finish_date, organization, visitor, messages', 'required'),
			array('status, message_reply', 'required', 'on'=>'reply'),
			array('status', 'required', 'on'=>'edit'),
			array('status, organization, visitor', 'numerical', 'integerOnly'=>true),
			array('visitor', 'length', 'max'=>3),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('organization_phone', 'length', 'max'=>15),
			array('organization_name', 'length', 'max'=>64),
			array('organization, organization_name, organization_address, organization_phone, message_file, message_reply,
				old_file', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('guest_id, status, author_id, start_date, finish_date, organization, organization_name, organization_address, organization_phone, visitor, messages, message_file, message_reply, creation_date, creation_id, modified_date, modified_id, 
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
			'author_TO' => array(self::BELONGS_TO, 'OmmuAuthors', 'author_id'),
			'creation_TO' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified_TO' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'visit_MANY' => array(self::HAS_MANY, 'Visits', 'guest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'guest_id' => 'Guest',
			'status' => 'Status',
			'author_id' => 'Author',
			'start_date' => 'Start Date',
			'finish_date' => 'Finish Date',
			'organization' => 'Organization',
			'organization_name' => 'Organization Name',
			'organization_address' => 'Organization Address',
			'organization_phone' => 'Organization Phone',
			'visitor' => 'Visitor',
			'messages' => 'Messages',
			'message_file' => 'Message File',
			'message_reply' => 'Message Reply',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'old_file' => 'Old Message File',
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

		$criteria->compare('t.guest_id',strtolower($this->guest_id),true);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.author_id',strtolower($this->author_id),true);
		if($this->start_date != null && !in_array($this->start_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.start_date)',date('Y-m-d', strtotime($this->start_date)));
		if($this->finish_date != null && !in_array($this->finish_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.finish_date)',date('Y-m-d', strtotime($this->finish_date)));
		$criteria->compare('t.organization',$this->organization);
		$criteria->compare('t.organization_name',strtolower($this->organization_name),true);
		$criteria->compare('t.organization_address',strtolower($this->organization_address),true);
		$criteria->compare('t.organization_phone',strtolower($this->organization_phone),true);
		$criteria->compare('t.visitor',$this->visitor);
		$criteria->compare('t.messages',strtolower($this->messages),true);
		$criteria->compare('t.message_file',strtolower($this->message_file),true);
		$criteria->compare('t.message_reply',strtolower($this->message_reply),true);
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
			'creation_TO' => array(
				'alias'=>'creation_TO',
				'select'=>'displayname',
			),
			'modified_TO' => array(
				'alias'=>'modified_TO',
				'select'=>'displayname',
			),
		);
		$criteria->compare('creation_TO.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified_TO.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['VisitGuest_sort']))
			$criteria->order = 'guest_id DESC';

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
			//$this->defaultColumns[] = 'guest_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'author_id';
			$this->defaultColumns[] = 'start_date';
			$this->defaultColumns[] = 'finish_date';
			$this->defaultColumns[] = 'organization';
			$this->defaultColumns[] = 'organization_name';
			$this->defaultColumns[] = 'organization_address';
			$this->defaultColumns[] = 'organization_phone';
			$this->defaultColumns[] = 'visitor';
			$this->defaultColumns[] = 'messages';
			$this->defaultColumns[] = 'message_file';
			$this->defaultColumns[] = 'message_reply';
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'organization',
					'value' => '$data->organization == 1 ? "Organization" : "Personal"',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>'Organization',
						0=>'Personal',
					),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'author_id',
				'value' => '$data->author_id != 0 ? ($data->organization == 1 ? $data->author_TO->name." (".$data->organization_name.")" : $data->author_TO->name) : $data->organization_name',
				
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
				'value' => 'Utility::dateFormat($data->finish_date)',
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
			$this->defaultColumns[] = array(
				'name' => 'visitor',
				'value' => '$data->visitor',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_TO->displayname',
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
			$this->defaultColumns[] = array(
				'name' => 'status',
				'value' => '$data->status == 0 ? "Pending" : ($data->status == 1 ? "Approved" : "Rejected")',
				'filter'=>array(
					0=>'Pending',
					1=>'Approved',
					2=>'Rejected',
				),
				'type' => 'raw',
			);
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;		
			else
				$this->modified_id = Yii::app()->user->id;
			
			if($this->organization == 1) {
				if($this->organization_name == '')
					$this->addError('organization_name', 'Organization Name cannot be blank.');
				if($this->organization_address == '')
					$this->addError('organization_address', 'Organization Address cannot be blank.');
				if($this->organization_phone == '')
					$this->addError('organization_phone', 'Organization Phone cannot be blank.');
			}
			
			$media = CUploadedFile::getInstance($this, 'message_file');
			if($media->name != '') {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('pdf','doc','opt','docx','ppt','pptx','zip', 'rar', '7z')))
					$this->addError('message_file', 'The file "'.$media->name.'" cannot be uploaded. Only files with these extensions are allowed: pdf, doc, opt, docx, ppt, pptx, zip, rar, 7z.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			$action = strtolower(Yii::app()->controller->action->id);
			
			$this->start_date = date('Y-m-d', strtotime($this->start_date));
			$this->finish_date = date('Y-m-d', strtotime($this->finish_date));
				
			//upload proposal
			if(in_array($action, array('add','edit')) || $currentAction == 'request/form') {
				$visit_path = "public/visit";
				$this->message_file = CUploadedFile::getInstance($this, 'message_file');
				if($this->message_file instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle($this->start_date.' '.$this->finish_date).'.'.strtolower($this->message_file->extensionName);
					if($this->message_file->saveAs($visit_path.'/'.$fileName)) {						
						if(!$this->isNewRecord && $this->old_file != '' && file_exists($visit_path.'/'.$this->old_file))
							rename($visit_path.'/'.$this->old_file, 'public/visit/verwijderen/'.$this->guest_id.'_'.$this->old_file);
						$this->message_file = $fileName;
					}
				}
				
				if(!$this->isNewRecord && $this->message_file == '') {
					$this->message_file = $this->old_file;
				}
			}
		}
		return true;	
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete visit image
		$visit_path = "public/visit";
		if($this->message_file != '' && file_exists($visit_path.'/'.$this->message_file)) {
			rename($visit_path.'/'.$this->message_file, 'public/visit/verwijderen/'.$this->guest_id.'_'.$this->message_file);
		}
	}

}