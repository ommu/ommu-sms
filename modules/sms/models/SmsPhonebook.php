<?php
/**
 * SmsPhonebook
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 12 February 2016, 17:25 WIB
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
 * This is the model class for table "ommu_sms_phonebook".
 *
 * The followings are the available columns in table 'ommu_sms_phonebook':
 * @property string $phonebook_id
 * @property integer $status
 * @property string $user_id
 * @property string $phonebook_nomor
 * @property string $phonebook_name
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 */
class SmsPhonebook extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $user_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsPhonebook the static model class
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
		return 'ommu_sms_phonebook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, phonebook_nomor', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, creation_id, modified_id', 'length', 'max'=>11),
			array('phonebook_nomor', 'length', 'max'=>15),
			array('user_id, phonebook_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('phonebook_id, status, user_id, phonebook_nomor, phonebook_name, creation_date, creation_id, modified_date, modified_id,
				user_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'modified_TO' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'geroupbook_ONE' => array(self::HAS_ONE, 'SmsGroupPhonebook', 'phonebook_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'phonebook_id' => Yii::t('attribute', 'Phonebook'),
			'status' => Yii::t('attribute', 'Status'),
			'user_id' => Yii::t('attribute', 'User'),
			'phonebook_nomor' => Yii::t('attribute', 'Phonebook Nomor'),
			'phonebook_name' => Yii::t('attribute', 'Phonebook Name'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'user_search' => Yii::t('attribute', 'User'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
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

		$criteria->compare('t.phonebook_id',strtolower($this->phonebook_id),true);
		$criteria->compare('t.status',$this->status);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.phonebook_nomor',strtolower($this->phonebook_nomor),true);
		$criteria->compare('t.phonebook_name',strtolower($this->phonebook_name),true);
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
			'user_TO' => array(
				'alias'=>'user_TO',
				'select'=>'displayname'
			),
			'creation_TO' => array(
				'alias'=>'creation_TO',
				'select'=>'displayname'
			),
			'modified_TO' => array(
				'alias'=>'modified_TO',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user_TO.displayname',strtolower($this->user_search), true);
		$criteria->compare('creation_TO.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified_TO.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['SmsPhonebook_sort']))
			$criteria->order = 't.phonebook_id DESC';

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
			//$this->defaultColumns[] = 'phonebook_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'phonebook_nomor';
			$this->defaultColumns[] = 'phonebook_name';
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
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user_id != 0 ? $data->user_TO->displayname : "-"',
			);
			$this->defaultColumns[] = 'phonebook_nomor';
			$this->defaultColumns[] = 'phonebook_name';
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
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js'
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'status',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("status",array("id"=>$data->phonebook_id)), $data->status, "Enable,Block")',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>'Block',
						0=>'Enable',
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
	 * User get information
	 */
	public static function setPhoneNumber($phonebook_nomor, $type=null)
	{
		$phonenumber = $phonebook_nomor;
		if($type == null) {
			if(substr($phonebook_nomor, 0, 1) != '+') {
				if(substr($phonebook_nomor, 0, 1) == '0')
					$phonenumber = '+62'.substr($phonebook_nomor, 1);
				else {
					if(substr($phonebook_nomor, 0, 2) == '62')
						$phonenumber = '+'.$phonebook_nomor;
					else
						$phonenumber = '+62'.$phonebook_nomor;
				}
			}			
		} else {
			if(substr($phonebook_nomor, 0, 1) == '+') {
				if(substr($phonebook_nomor, 0, 3) == '+62')
					$phonenumber = '0'.substr($phonebook_nomor, 3);
			} else {
				if(substr($phonebook_nomor, 0, 3) != '0' && substr($phonebook_nomor, 0, 2) == '62')
					$phonenumber = '0'.substr($phonebook_nomor, 2);
			}
		}
		
		return $phonenumber;
	}

	/**
	 * User get information
	 */
	public static function insertPhonebook($user_id, $phonebook_nomor, $phonebook_name)
	{
		$return = true;
		
		$model=new SmsPhonebook;
		
		$model->user_id = $user_id;
		$model->phonebook_nomor = $phonebook_nomor;
		$model->phonebook_name = $phonebook_name;
		if($model->save())
			$return = $model->phonebook_id;
		
		return $return;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {				
				$this->phonebook_nomor = self::setPhoneNumber($this->phonebook_nomor);
				$phonebook = SmsPhonebook::model()->find(array(
					'select'    => 'phonebook_id',
					'condition' => 'phonebook_nomor= :p_nomor',
					'params'    => array(':p_nomor' => $this->phonebook_nomor),
				));
				if($phonebook != null)
					$this->addError('phonebook_nomor', Yii::t('phrase', 'Contact sudah ada pada database.'));
					
				$this->creation_id = Yii::app()->user->id;				
			}
			else
				$this->modified_id = Yii::app()->user->id;
			
		}
		return true;
	}

}