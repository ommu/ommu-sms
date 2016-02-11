<?php
/**
 * SmsInbox
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
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
 * This is the model class for table "ommu_sms_inbox".
 *
 * The followings are the available columns in table 'ommu_sms_inbox':
 * @property string $inbox_id
 * @property string $user_id
 * @property string $smsc_source
 * @property string $smsc_sender
 * @property string $sender_nomor
 * @property string $message
 * @property integer $readed
 * @property integer $queue_no
 * @property integer $group
 * @property integer $reply
 * @property integer $status
 * @property string $message_date
 * @property string $creation_date
 * @property integer $c_timestamp
 */
class SmsInbox extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsInbox the static model class
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
		return 'ommu_sms_inbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender_nomor, message', 'required'),
			array('readed, queue_no, group, reply, c_timestamp', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('smsc_source, smsc_sender, sender_nomor', 'length', 'max'=>15),
			array('message_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('inbox_id, user_id, smsc_source, smsc_sender, sender_nomor, message, readed, queue_no, group, reply, status, message_date, creation_date, c_timestamp', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inbox_id' => 'Inbox',
			'user_id' => 'User',
			'smsc_source' => 'Smsc Source',
			'smsc_sender' => 'Smsc Sender',
			'sender_nomor' => 'Sender Nomor',
			'message' => 'Message',
			'readed' => 'Readed',
			'queue_no' => 'Queue No',
			'group' => 'Group',
			'reply' => 'Reply',
			'status' => 'Status',
			'message_date' => 'Message Date',
			'creation_date' => 'Creation Date',
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

		$criteria->compare('t.inbox_id',strtolower($this->inbox_id),true);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.smsc_source',strtolower($this->smsc_source),true);
		$criteria->compare('t.smsc_sender',strtolower($this->smsc_sender),true);
		$criteria->compare('t.sender_nomor',strtolower($this->sender_nomor),true);
		$criteria->compare('t.message',strtolower($this->message),true);
		$criteria->compare('t.readed',$this->readed);
		$criteria->compare('t.queue_no',$this->queue_no);
		$criteria->compare('t.group',$this->group);
		$criteria->compare('t.reply',$this->reply);
		$criteria->compare('t.status',$this->status);
		if($this->message_date != null && !in_array($this->message_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.message_date)',date('Y-m-d', strtotime($this->message_date)));
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.c_timestamp',$this->c_timestamp);

		if(!isset($_GET['SmsInbox_sort']))
			$criteria->order = 't.inbox_id DESC';

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
			//$this->defaultColumns[] = 'inbox_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'smsc_source';
			$this->defaultColumns[] = 'smsc_sender';
			$this->defaultColumns[] = 'sender_nomor';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = 'readed';
			$this->defaultColumns[] = 'queue_no';
			$this->defaultColumns[] = 'group';
			$this->defaultColumns[] = 'reply';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'message_date';
			$this->defaultColumns[] = 'creation_date';
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
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'sender_nomor';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = array(
				'name' => 'message_date',
				'value' => 'Utility::dateFormat($data->message_date, true)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'message_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'message_date_filter',
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
			$this->defaultColumns[] = 'readed';
			$this->defaultColumns[] = 'queue_no';
			$this->defaultColumns[] = 'group';
			$this->defaultColumns[] = 'reply';
			$this->defaultColumns[] = 'status';
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
			$this->c_timestamp = time();
		}
		return true;
	}

}