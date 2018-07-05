<?php
/**
 * SmsGroupPhonebook
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 12 February 2016, 18:27 WIB
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
 * This is the model class for table "ommu_sms_group_phonebook".
 *
 * The followings are the available columns in table 'ommu_sms_group_phonebook':
 * @property string $id
 * @property integer $status
 * @property integer $group_id
 * @property string $phonebook_id
 * @property string $creation_date
 * @property string $creation_id
 */
class SmsGroupPhonebook extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $group_search;
	public $phonebook_name_search;
	public $phonebook_nomor_search;
	public $creation_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsGroupPhonebook the static model class
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
		return 'ommu_sms_group_phonebook';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, phonebook_id', 'required'),
			array('status, group_id', 'numerical', 'integerOnly'=>true),
			array('phonebook_id, creation_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, group_id, phonebook_id, creation_date, creation_id,
				group_search, phonebook_name_search, phonebook_nomor_search, creation_search', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'SmsGroups', 'group_id'),
			'phonebook' => array(self::BELONGS_TO, 'SmsPhonebook', 'phonebook_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'status' => Yii::t('attribute', 'Status'),
			'group_id' => Yii::t('attribute', 'Group'),
			'phonebook_id' => Yii::t('attribute', 'Phonebook'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'group_search' => Yii::t('attribute', 'Group'),
			'phonebook_name_search' => Yii::t('attribute', 'Phonebook'),
			'phonebook_nomor_search' => Yii::t('attribute', 'Phonebook Nomor'),
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

		$criteria->compare('t.id', strtolower($this->id), true);
		$criteria->compare('t.status', $this->status);
		if(Yii::app()->getRequest()->getParam('group'))
			$criteria->compare('t.group_id', Yii::app()->getRequest()->getParam('group'));
		else
			$criteria->compare('t.group_id', $this->group_id);
		$criteria->compare('t.phonebook_id', strtolower($this->phonebook_id), true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		
		// Custom Search
		$criteria->with = array(
			'group' => array(
				'alias'=>'group',
				'select'=>'group_name, group_desc'
			),
			'phonebook' => array(
				'alias'=>'phonebook',
				'select'=>'phonebook_nomor, phonebook_name'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
		);
		$criteria->compare('group.group_name', strtolower($this->group_search), true);
		$criteria->compare('phonebook.phonebook_name', strtolower($this->phonebook_name_search), true);
		$criteria->compare('phonebook.phonebook_nomor', strtolower($this->phonebook_nomor_search), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);

		if(!Yii::app()->getRequest()->getParam('SmsGroupPhonebook_sort'))
			$criteria->order = 't.id DESC';

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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'phonebook_id';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
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
			if(!Yii::app()->getRequest()->getParam('group')) {
				$this->defaultColumns[] = array(
					//'name' => 'group_search',
					'name' => 'group_id',
					'value' => '$data->group->group_name',
					'filter'=> SmsGroups::getGroup(),
					'type' => 'raw',
				);
			}
			if(!Yii::app()->getRequest()->getParam('phonebook')) {
				$this->defaultColumns[] = array(
					'name' => 'phonebook_name_search',
					'value' => '$data->phonebook->phonebook_name',
				);
			$this->defaultColumns[] = array(
				'name' => 'phonebook_nomor_search',
				'value' => '$data->phonebook->phonebook_nomor',
			);
			}
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
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
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
						'dateFormat' => 'yy-mm-dd',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'status',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("status", array("id"=>$data->id)), $data->status, "Disable,Enable")',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>'Enable',
						0=>'Disable',
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
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
		}
		return true;
	}

}