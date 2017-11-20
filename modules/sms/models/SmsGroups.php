<?php
/**
 * SmsGroups
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @created date 12 February 2016, 18:26 WIB
 * @link https://github.com/ommu/mod-sms
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
 * This is the model class for table "ommu_sms_groups".
 *
 * The followings are the available columns in table 'ommu_sms_groups':
 * @property integer $group_id
 * @property integer $status
 * @property string $group_name
 * @property string $group_desc
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 */
class SmsGroups extends CActiveRecord
{
	public $defaultColumns = array();
	public $contact_input;
	public $import_excel;
	public $groupbookExcel;
	public $errorRowImport = array();
	
	// Variable Search
	public $creation_search;
	public $modified_search;
	public $contact_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmsGroups the static model class
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
		return 'ommu_sms_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name, group_desc', 'required'),
			array('status,
				import_excel', 'numerical', 'integerOnly'=>true),
			array('group_name,
				contact_input', 'length', 'max'=>32),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('
				contact_input, import_excel, groupbookExcel', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_id, status, group_name, group_desc, creation_date, creation_id, modified_date, modified_id,
				creation_search, modified_search, contact_search', 'safe', 'on'=>'search'),
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
			'view' => array(self::BELONGS_TO, 'ViewSmsGroups', 'group_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'phonebooks' => array(self::HAS_MANY, 'SmsGroupPhonebook', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => Yii::t('attribute', 'Group'),
			'status' => Yii::t('attribute', 'Status'),
			'group_name' => Yii::t('attribute', 'Group'),
			'group_desc' => Yii::t('attribute', 'Description'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'contact_input' => Yii::t('attribute', 'Contact in Group'),
			'import_excel' => Yii::t('attribute', 'Import Group Phonebook'),
			'groupbookExcel' => Yii::t('attribute', 'Group Phonebook Excel'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'contact_search' => Yii::t('attribute', 'Contacts'),
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
			'view' => array(
				'alias'=>'view',
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);

		$criteria->compare('t.group_id',$this->group_id);
		$criteria->compare('t.status',$this->status);
		$criteria->compare('t.group_name',strtolower($this->group_name),true);
		$criteria->compare('t.group_desc',strtolower($this->group_desc),true);
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
		
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);
		$criteria->compare('view.contacts',$this->contact_search);

		if(!isset($_GET['SmsGroups_sort']))
			$criteria->order = 't.group_id DESC';

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
			//$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'group_name';
			$this->defaultColumns[] = 'group_desc';
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
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'group_name';
			$this->defaultColumns[] = 'group_desc';
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
				'name' => 'contact_search',
				'value' => 'CHtml::link($data->view->contacts ? $data->view->contacts : 0, Yii::app()->controller->createUrl("o/groupbook/manage",array("group"=>$data->group_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'status',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("status",array("id"=>$data->group_id)), $data->status, "Disable,Enable")',
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
	 * Get category
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getGroup($status=null) 
	{		
		$criteria=new CDbCriteria;
		if($status != null)
			$criteria->compare('status',$status);
		
		$model = self::model()->findAll($criteria);

		$items = array();
		if($model != null) {
			foreach($model as $key => $val) {
				$items[$val->group_id] = $val->group_name;
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
			
			else {
				if($this->import_excel == 1) {
					$file = CUploadedFile::getInstance($this, 'groupbookExcel');
					if($file != null) {
						$extension = pathinfo($file->name, PATHINFO_EXTENSION);
						if(!in_array(strtolower($extension), array('xls','xlsx')))
							$this->addError('groupbookExcel', Yii::t('phrase', 'The file $filename cannot be uploaded. Only files with these extensions are allowed: xls, xlsx.', array('$filename'=>$file->name)));
					} else
						$this->addError('groupbookExcel', Yii::t('phrase', 'File import cannot be blank.'));
				}
				
				$this->modified_id = Yii::app()->user->id;
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		if(parent::beforeSave()) 
		{
			$sms_path = 'public/sms';
			if(!file_exists($sms_path)) {
				mkdir($sms_path, 0755, true);

				// Add File in User Folder (index.php)
				$newFile = $sms_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($sms_path, 0755, true);
			
			if(!$this->isNewRecord) 
			{
				$this->groupbookExcel = CUploadedFile::getInstance($this, 'groupbookExcel');
				if($this->groupbookExcel instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle(date('d-m-Y H:i:s')).'_'.Utility::getUrlTitle(Yii::app()->user->displayname).'.'.strtolower($this->groupbookExcel->extensionName);
					if($this->groupbookExcel->saveAs($sms_path.'/'.$fileName)) {
						Yii::import('ext.excel_reader.OExcelReader');
						$xls = new OExcelReader($sms_path.'/'.$fileName);
					
						for ($row = 2; $row <= $xls->sheets[0]['numRows']; $row++) {
							$no						= trim($xls->sheets[0]['cells'][$row][1]);
							$phonebook_name			= trim($xls->sheets[0]['cells'][$row][2]);
							$phonebook_nomor		= trim($xls->sheets[0]['cells'][$row][3]);
							
							$phonebook_nomor = SmsPhonebook::setPhoneNumber($phonebook_nomor);
							
							$phonebook = SmsPhonebook::model()->find(array(
								'select'    => 'phonebook_id',
								'condition' => 'phonebook_nomor=:nomor',
								'params'    => array(
									':nomor' => $phonebook_nomor,
								),
							));
							if($phonebook != null)
								$phonebook_id = $phonebook->phonebook_id;								
							else
								$phonebook_id = SmsPhonebook::insertPhonebook($phonebook_nomor, $phonebook_name);
							
							$groupbook = SmsGroupPhonebook::model()->find(array(
								'select'    => 'id',
								'condition' => 'group_id= :group AND phonebook_id= :phonebook',
								'params'    => array(
									':group' => $this->group_id,
									':phonebook' => $phonebook_id,
								),
							));
							
							if($groupbook == null) {							
								$model=new SmsGroupPhonebook;
								$model->group_id = $this->group_id;
								$model->phonebook_id = $phonebook_id;
								if(!$model->save())
									array_push($this->errorRowImport, $row);
								
							} else
								array_push($this->errorRowImport, $row);
						}
						
					} else
						$this->addError('groupbookExcel', Yii::t('phrase', 'Data excel gagal terupload.'));
				}				
			}
		}
		return true;
	}

}