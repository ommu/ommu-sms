<?php
/**
 * BookMasterAuthors * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
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
 * This is the model class for table "ommu_book_master_authors".
 *
 * The followings are the available columns in table 'ommu_book_master_authors':
 * @property string $author_id
 * @property integer $publish
 * @property string $author_name
 * @property string $author_photo
 * @property string $website
 * @property string $wikipedia
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuBookAuthor[] $ommuBookAuthors
 * @property OmmuBookInterpreter[] $ommuBookInterpreters
 */
class BookMasterAuthors extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_photo;
	
	// Variable Search
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookMasterAuthors the static model class
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
		return 'ommu_book_master_authors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author_name', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('author_name, author_photo,
				old_photo', 'length', 'max'=>64),
			array('website, wikipedia', 'length', 'max'=>128),
			array('creation_id, modified_id', 'length', 'max'=>11),
			//array('author_photo', 'file', 'types' => 'jpg, jpeg, png, gif', 'allowEmpty' => true),
			array('author_photo, website, wikipedia, creation_date, creation_id, modified_date, modified_id,
				old_photo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('author_id, publish, author_name, author_photo, website, wikipedia, creation_date, creation_id, modified_date, modified_id,
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
			'author' => array(self::HAS_MANY, 'BookAuthor', 'author_id'),
			'interpreter' => array(self::HAS_MANY, 'BookInterpreter', 'interpreter_id'),
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
			'author_id' => 'Author',
			'publish' => 'Publish',
			'author_name' => 'Author Name',
			'author_photo' => 'Author Photo',
			'website' => 'Website',
			'wikipedia' => 'Wikipedia',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'creation_search' => 'Creation',
			'modified_search' => 'Modified',
			'old_photo' => 'Old Photo',
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

		$criteria->compare('t.author_id',$this->author_id,true);
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
		$criteria->compare('t.author_name',$this->author_name,true);
		$criteria->compare('t.author_photo',$this->author_photo,true);
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

		if(!isset($_GET['BookMasterAuthors_sort']))
			$criteria->order = 'author_id DESC';

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
			//$this->defaultColumns[] = 'author_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'author_name';
			$this->defaultColumns[] = 'author_photo';
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
			$this->defaultColumns[] = 'author_name';
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
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->author_id)), $data->publish, 1)',
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
			
			$author_photo = CUploadedFile::getInstance($this, 'author_photo');
			if($author_photo->name != '') {
				$extension = pathinfo($author_photo->name, PATHINFO_EXTENSION);
				if(!in_array($extension, array('bmp','gif','jpg','png')))
					$this->addError('author_photo', 'The file "'.$author_photo->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->author_name = strtolower($this->author_name);
			
			//Update author photo
			$controller = strtolower(Yii::app()->controller->id);
			if(!$this->isNewRecord && $controller == 'masterauthor' && !Yii::app()->request->isAjaxRequest) {
				$author_path = "public/book/author/";
				
				$this->author_photo = CUploadedFile::getInstance($this, 'author_photo');
				if($this->author_photo instanceOf CUploadedFile) {
					$fileName = $this->author_id.'_'.time().'.'.strtolower($this->author_photo->extensionName);
					if($this->author_photo->saveAs($author_path.'/'.$fileName)) {
						if($this->old_photo != '')
							rename($author_path.'/'.$this->old_photo, 'public/book/verwijderen/author_'.$this->old_photo);
						$this->author_photo = $fileName;
					}
				}
					
				if($this->author_photo == '') {
					$this->author_photo = $this->old_photo;
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
		if($this->isNewRecord && $controller == 'masterauthor' && !Yii::app()->request->isAjaxRequest) {
			$author_path = "public/book/author/";
			
			$this->author_photo = CUploadedFile::getInstance($this, 'author_photo');
			if($this->author_photo instanceOf CUploadedFile) {
				$fileName = $this->author_id.'_'.time().'.'.strtolower($this->author_photo->extensionName);
				if($this->author_photo->saveAs($author_path.'/'.$fileName)) {
					BookMasterAuthors::model()->updateByPk($this->author_id, array('author_photo'=>$fileName));
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
		$author_path = "public/book/author/";
		if($this->author_photo != '')
			rename($author_path.'/'.$this->author_photo, 'public/book/verwijderen/author_'.$this->author_photo);
	}

}