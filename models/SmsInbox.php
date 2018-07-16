<?php
/**
 * SmsInbox
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 04:03 WIB
 * @link https://github.com/ommu/ommu-sms
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
 * @property string $phonebook_id
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
	use GridViewTrait;

	public $defaultColumns = array();
	
	// Variable Search
	public $phonebook_search;

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
			array('phonebook_id', 'length', 'max'=>11),
			array('smsc_source, smsc_sender, sender_nomor', 'length', 'max'=>15),
			array('message_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('inbox_id, phonebook_id, smsc_source, smsc_sender, sender_nomor, message, readed, queue_no, group, reply, status, message_date, creation_date, c_timestamp,
				phonebook_search', 'safe', 'on'=>'search'),
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
			'phonebook' => array(self::BELONGS_TO, 'SmsPhonebook', 'phonebook_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inbox_id' => Yii::t('attribute', 'Inbox'),
			'phonebook_id' => Yii::t('attribute', 'Phonebook'),
			'smsc_source' => Yii::t('attribute', 'Smsc Source'),
			'smsc_sender' => Yii::t('attribute', 'Smsc Sender'),
			'sender_nomor' => Yii::t('attribute', 'Sender Nomor'),
			'message' => Yii::t('attribute', 'Message'),
			'readed' => Yii::t('attribute', 'Readed'),
			'queue_no' => Yii::t('attribute', 'Queue No'),
			'group' => Yii::t('attribute', 'Group'),
			'reply' => Yii::t('attribute', 'Reply'),
			'status' => Yii::t('attribute', 'Status'),
			'message_date' => Yii::t('attribute', 'Message Date'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'c_timestamp' => Yii::t('attribute', 'C Timestamp'),
			'phonebook_search' => Yii::t('attribute', 'Phonebook'),
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
		
		// Custom Search
		$criteria->with = array(
			'phonebook' => array(
				'alias'=>'phonebook',
				'select'=>'phonebook_name'
			),
		);

		$criteria->compare('t.inbox_id', strtolower($this->inbox_id), true);
		if(Yii::app()->getRequest()->getParam('phonebook'))
			$criteria->compare('t.phonebook_id', Yii::app()->getRequest()->getParam('phonebook'));
		else
			$criteria->compare('t.phonebook_id', $this->phonebook_id);
		$criteria->compare('t.smsc_source', strtolower($this->smsc_source), true);
		$criteria->compare('t.smsc_sender', strtolower($this->smsc_sender), true);
		$criteria->compare('t.sender_nomor', strtolower($this->sender_nomor), true);
		$criteria->compare('t.message', strtolower($this->message), true);
		$criteria->compare('t.readed', $this->readed);
		$criteria->compare('t.queue_no', $this->queue_no);
		$criteria->compare('t.group', $this->group);
		$criteria->compare('t.reply', $this->reply);
		$criteria->compare('t.status', $this->status);
		if($this->message_date != null && !in_array($this->message_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.message_date)', date('Y-m-d', strtotime($this->message_date)));
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.c_timestamp', $this->c_timestamp);
		
		$criteria->compare('phonebook.phonebook_name', strtolower($this->phonebook_search), true);

		if(!Yii::app()->getRequest()->getParam('SmsInbox_sort'))
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
			$this->defaultColumns[] = array(
				'name' => 'phonebook_search',
				'value' => '$data->phonebook_id != 0 ? $data->phonebook->phonebook_name : $data->phonebook->phonebook_nomor',
			);
			$this->defaultColumns[] = 'sender_nomor';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'creation_date'),
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
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
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

	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		if(parent::beforeSave()) {
			$this->sender_nomor = SmsPhonebook::setPhoneNumber($this->sender_nomor);
		}
		return true;
	}

}