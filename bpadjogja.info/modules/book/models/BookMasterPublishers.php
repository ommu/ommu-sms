<?php
/**
 * BookMasterPublishers * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
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
 * This is the model class for table "ommu_book_master_publishers".
 *
 * The followings are the available columns in table 'ommu_book_master_publishers':
 * @property string $publisher_id
 * @property integer $publish
 * @property string $publisher_name
 * @property string $publisher_logo
 * @property string $address
 * @property string $location
 * @property string $website
 * @property string $wikipedia
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuBookMasters[] $ommuBookMasters
 */
class BookMasterPublishers extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_logo;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookMasterPublishers the static model class
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
		return 'ommu_book_master_publishers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publisher_name', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('publisher_name, publisher_logo, location,
				old_logo', 'length', 'max'=>64),
			array('website, wikipedia', 'length', 'max'=>128),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('publisher_logo, address, location, website, wikipedia, creation_date, creation_id, modified_date, modified_id,
				old_logo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('publisher_id, publish, publisher_name, publisher_logo, address, location, website, wikipedia, creation_date, creation_id, modified_date, modified_id,
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
			'book' => array(self::HAS_MANY, 'BookMasters', 'publisher_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'publisher_id' => 'Publisher',
			'publish' => 'Publish',
			'publisher_name' => 'Publisher Name',
			'publisher_logo' => 'Publisher Logo',
			'address' => 'Address',
			'location' => 'Location',
			'website' => 'Website',
			'wikipedia' => 'Wikipedia',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'creation_search' => 'Creation',
			'modified_search' => 'Modified',
			'old_logo' => 'Publisher Logo',
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

		$criteria->compare('t.publisher_id',$this->publisher_id,true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish') {
			$criteria->compare('t.publish',1);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish') {
			$criteria->compare('t.publish',0);
		} elseif(isset($_GET['type']) && $_GET['type'] == 'trash') {
			$criteria->compare('t.publish',2);
		} else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		$criteria->compare('t.publisher_name',$this->publisher_name,true);
		$criteria->compare('t.publisher_logo',$this->publisher_logo,true);
		$criteria->compare('t.address',$this->address,true);
		$criteria->compare('t.location',$this->location,true);
		$criteria->compare('t.website',$this->website,true);
		$criteria->compare('t.wikipedia',$this->wikipedia,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id,true);
		
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
		);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['BookMasterPublishers_sort']))
			$criteria->order = 't.publisher_id DESC';

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
			//$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'publisher_name';
			$this->defaultColumns[] = 'publisher_logo';
			$this->defaultColumns[] = 'address';
			$this->defaultColumns[] = 'location';
			$this->defaultColumns[] = 'website';
			$this->defaultColumns[] = 'wikipedia';
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
			$this->defaultColumns[] = 'publisher_name';
			$this->defaultColumns[] = 'address';
			$this->defaultColumns[] = 'website';
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
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->publisher_id)), $data->publish, 1)',
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
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				$this->creation_id = Yii::app()->user->id;			
			} else {
				$this->modified_id = Yii::app()->user->id;					
			}
			
			$publisher_logo = CUploadedFile::getInstance($this, 'publisher_logo');
			if($publisher_logo->name != '') {
				$extension = pathinfo($publisher_logo->name, PATHINFO_EXTENSION);
				if(!in_array($extension, array('bmp','gif','jpg','png')))
					$this->addError('publisher_logo', 'The file "'.$publisher_logo->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->publisher_name = strtolower($this->publisher_name);
			
			//Update publisher logo
			$controller = strtolower(Yii::app()->controller->id);
			if(!$this->isNewRecord && $controller == 'masterpublisher' && !Yii::app()->request->isAjaxRequest) {
				$publisher_path = "public/book/publisher/";
				
				$this->publisher_logo = CUploadedFile::getInstance($this, 'publisher_logo');
				if($this->publisher_logo instanceOf CUploadedFile) {
					$fileName = $this->publisher_id.'_'.time().'.'.strtolower($this->publisher_logo->extensionName);
					if($this->publisher_logo->saveAs($publisher_path.'/'.$fileName)) {
						if($this->old_logo != '')
							rename($publisher_path.'/'.$this->old_logo, 'public/book/verwijderen/publisher_'.$this->old_logo);
						$this->publisher_logo = $fileName;
					}
				}
					
				if($this->publisher_logo == '') {
					$this->publisher_logo = $this->old_logo;
				}	
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() {
		parent::afterSave();
			
		//Update author photo
		$controller = strtolower(Yii::app()->controller->id);
		if($this->isNewRecord && $controller == 'masterpublisher' && !Yii::app()->request->isAjaxRequest) {
			$publisher_path = "public/book/publisher/";
			
			$this->publisher_logo = CUploadedFile::getInstance($this, 'publisher_logo');
			if($this->publisher_logo instanceOf CUploadedFile) {
				$fileName = $this->publisher_id.'_'.time().'.'.strtolower($this->publisher_logo->extensionName);
				if($this->publisher_logo->saveAs($publisher_path.'/'.$fileName)) {
					BookMasterPublishers::model()->updateByPk($this->publisher_id, array('publisher_logo'=>$fileName));
				}
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete article image
		$publisher_path = "public/book/publisher/";
		if($this->publisher_logo != '')
			rename($publisher_path.'/'.$this->publisher_logo, 'public/book/verwijderen/publisher_'.$this->publisher_logo);
	}

}