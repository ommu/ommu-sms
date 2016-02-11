<?php
/**
 * SmsOutbox
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 11 February 2016, 18:55 WIB
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
 * @property integer $smslog_id
 * @property integer $status
 * @property string $user_id
 * @property string $group_id
 * @property string $reply_id
 * @property string $destination_smsc
 * @property string $destination_nomor
 * @property string $destination_message
 * @property string $creation_date
 * @property string $creation_id
 * @property string $updated_date
 * @property string $reply_date
 * @property integer $c_timestamp
 *
 * The followings are the available model relations:
 * @property OmmuSmsKannelDlr[] $ommuSmsKannelDlrs
 */
class SmsOutbox extends CActiveRecord
{
	public $defaultColumns = array();

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
			array('destination_nomor, destination_message', 'required'),
			array('status, c_timestamp', 'numerical', 'integerOnly'=>true),
			array('user_id, group_id, reply_id, creation_id', 'length', 'max'=>11),
			array('destination_smsc, destination_nomor', 'length', 'max'=>15),
			array('updated_date, reply_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('smslog_id, status, user_id, group_id, reply_id, destination_smsc, destination_nomor, destination_message, creation_date, creation_id, updated_date, reply_date, c_timestamp', 'safe', 'on'=>'search'),
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
			//'ommuSmsKannelDlrs_relation' => array(self::HAS_MANY, 'OmmuSmsKannelDlr', 'smslog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'smslog_id' => 'Smslog',
			'status' => 'Status',
			'user_id' => 'User',
			'group_id' => 'Group',
			'reply_id' => 'Reply',
			'destination_smsc' => 'Destination Smsc',
			'destination_nomor' => 'Destination Nomor',
			'destination_message' => 'Destination Message',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'updated_date' => 'Updated Date',
			'reply_date' => 'Reply Date',
			'c_timestamp' => 'C Timestamp',
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

		$criteria->compare('t.smslog_id',$this->smslog_id);
		$criteria->compare('t.status',$this->status);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.group_id',strtolower($this->group_id),true);
		$criteria->compare('t.reply_id',strtolower($this->reply_id),true);
		$criteria->compare('t.destination_smsc',strtolower($this->destination_smsc),true);
		$criteria->compare('t.destination_nomor',strtolower($this->destination_nomor),true);
		$criteria->compare('t.destination_message',strtolower($this->destination_message),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.updated_date)',date('Y-m-d', strtotime($this->updated_date)));
		if($this->reply_date != null && !in_array($this->reply_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.reply_date)',date('Y-m-d', strtotime($this->reply_date)));
		$criteria->compare('t.c_timestamp',$this->c_timestamp);

		if(!isset($_GET['SmsOutbox_sort']))
			$criteria->order = 't.smslog_id DESC';

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
			//$this->defaultColumns[] = 'smslog_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'reply_id';
			$this->defaultColumns[] = 'destination_smsc';
			$this->defaultColumns[] = 'destination_nomor';
			$this->defaultColumns[] = 'destination_message';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'updated_date';
			$this->defaultColumns[] = 'reply_date';
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'status',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("status",array("id"=>$data->smslog_id)), $data->status, 1)',
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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'reply_id';
			$this->defaultColumns[] = 'destination_smsc';
			$this->defaultColumns[] = 'destination_nomor';
			$this->defaultColumns[] = 'destination_message';
			/*
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
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = array(
				'name' => 'updated_date',
				'value' => 'Utility::dateFormat($data->updated_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'updated_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'updated_date_filter',
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
				'name' => 'reply_date',
				'value' => 'Utility::dateFormat($data->reply_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'reply_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'reply_date_filter',
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
				$this->user_id = Yii::app()->user->id;
			
			$this->c_timestamp = time();
		}
		return true;
	}

}