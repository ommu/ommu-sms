<?php
/**
 * SmsOutbox
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 04:03 WIB
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
 * This is the model class for table "ommu_sms_outbox".
 *
 * The followings are the available columns in table 'ommu_sms_outbox':
 * @property integer $outbox_id
 * @property integer $status
 * @property string $user_id
 * @property string $group_id
 * @property string $smsc_source
 * @property string $smsc_destination
 * @property string $destination_nomor
 * @property string $message
 * @property string $creation_date
 * @property string $creation_id
 * @property string $updated_date
 * @property integer $c_timestamp
 *
 * The followings are the available model relations:
 * @property SmsKannelDlr[] $SmsKannelDlrs
 */
class SmsOutbox extends CActiveRecord
{
	public $defaultColumns = array();
	public $messageType;
	public $contact_input;
	public $multiple_input;
	public $group_input;
	public $errorSendSms = array();
	
	// Variable Search
	public $user_search;
	public $creation_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsOutbox the static model class
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
		return 'ommu_sms_outbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required'),
			array('status, c_timestamp,
				messageType', 'numerical', 'integerOnly'=>true),
			array('user_id, group_id, creation_id', 'length', 'max'=>11),
			array('smsc_source, smsc_destination, destination_nomor', 'length', 'max'=>15),
			array('destination_nomor,
				messageType, contact_input, multiple_input, group_input', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('outbox_id, status, user_id, group_id, smsc_source, smsc_destination, destination_nomor, message, creation_date, creation_id, updated_date, c_timestamp,
				user_search, creation_search', 'safe', 'on'=>'search'),
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
			'user_TO' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'creation_TO' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			//'ommuSmsKannelDlrs_relation' => array(self::HAS_MANY, 'OmmuSmsKannelDlr', 'smslog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'outbox_id' => Yii::t('attribute', 'Outbox'),
			'status' => Yii::t('attribute', 'Status'),
			'user_id' => Yii::t('attribute', 'User'),
			'group_id' => Yii::t('attribute', 'Group'),
			'smsc_source' => Yii::t('attribute', 'Smsc Source'),
			'smsc_destination' => Yii::t('attribute', 'Smsc Destination'),
			'destination_nomor' => Yii::t('attribute', 'Destination Nomor'),
			'message' => Yii::t('attribute', 'Message'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'updated_date' => Yii::t('attribute', 'Updated Date'),
			'c_timestamp' => Yii::t('attribute', 'C Timestamp'),
			'messageType' => Yii::t('attribute', 'SMS Type'),
			'contact_input' => Yii::t('attribute', 'Destination Nomor'),
			'multiple_input' => Yii::t('attribute', 'Destination Nomor'),
			'group_input' => Yii::t('attribute', 'Phonebook Group'),
			'user_search' => Yii::t('attribute', 'User'),
			'creation_search' => Yii::t('attribute', 'Creation'),
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

		$criteria->compare('t.outbox_id',$this->outbox_id);
		$criteria->compare('t.status',$this->status);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		if(isset($_GET['group']))
			$criteria->compare('t.group_id',$_GET['group']);
		else
			$criteria->compare('t.group_id',$this->group_id);
		$criteria->compare('t.smsc_source',strtolower($this->smsc_source),true);
		$criteria->compare('t.smsc_destination',strtolower($this->smsc_destination),true);
		$criteria->compare('t.destination_nomor',strtolower($this->destination_nomor),true);
		$criteria->compare('t.message',strtolower($this->message),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.updated_date)',date('Y-m-d', strtotime($this->updated_date)));
		$criteria->compare('t.c_timestamp',$this->c_timestamp);
		
		// Custom Search
		$criteria->with = array(
			'user_TO' => array(
				'alias'=>'user_TO',
				'select'=>'displayname'
			),
			'creation_TO' => array(
				'alias'=>'creation_TO',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user_TO.displayname',strtolower($this->user_search), true);
		$criteria->compare('creation_TO.displayname',strtolower($this->creation_search), true);

		if(!isset($_GET['SmsOutbox_sort']))
			$criteria->order = 't.outbox_id DESC';

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
			//$this->defaultColumns[] = 'outbox_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'smsc_source';
			$this->defaultColumns[] = 'smsc_destination';
			$this->defaultColumns[] = 'destination_nomor';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'updated_date';
			$this->defaultColumns[] = 'c_timestamp';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			/*
			$this->defaultColumns[] = array(
				'name' => 'group_id',
				'value' => '$data->group_id == 0 ? "-" : ""',
			);
			*/
			$this->defaultColumns[] = array(
				'name' => 'destination_nomor',
				'value' => '$data->noted != "" ? $data->noted : $data->destination_nomor',
			);
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_TO->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date, true)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
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
				'value' => '$data->status == 0 ? Yii::t(\'phrase\', \'Pending\') : ($data->status == 1 ? Yii::t(\'phrase\', \'Sent\') : ($data->status == 2 ? Yii::t(\'phrase\', \'Failed\') : Yii::t(\'phrase\', \'Delivered\')))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					0=>Yii::t('phrase', 'Pending'),
					1=>Yii::t('phrase', 'Sent'),
					2=>Yii::t('phrase', 'Failed'),
					3=>Yii::t('phrase', 'Delivered'),
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
	 * User get information
	 */
	public static function insertOutbox($destination_nomor, $message, $outboxGroup=0)
	{
		$return = true;		
		
		$model=new SmsOutbox;
		$model->group_id = $outboxGroup;
		$model->destination_nomor = $destination_nomor;
		$model->message = $message;
		if($model->save())
			$return = $model->outbox_id;
		
		return $return;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->user_id = Yii::app()->user->id;
			
			if($this->messageType == 1 && $this->contact_input == '')
				$this->addError('contact_input', Yii::t('phrase', 'Destination number cannot be blank.'));
			
			if($this->messageType == 3 && $this->group_input == '')
				$this->addError('group_input', Yii::t('phrase', 'Phonebook group cannot be blank.'));
			
			$this->c_timestamp = time();
		}
		return true;
	}

}