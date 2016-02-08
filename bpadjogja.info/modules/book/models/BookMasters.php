<?php
/**
 * BookMasters * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
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
 * This is the model class for table "ommu_book_masters".
 *
 * The followings are the available columns in table 'ommu_book_masters':
 * @property string $book_id
 * @property integer $publish
 * @property string $publisher_id
 * @property string $isbn
 * @property string $title
 * @property string $description
 * @property string $cover
 * @property string $edition
 * @property string $publish_city
 * @property string $publish_year
 * @property string $paging
 * @property string $sizes
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuBookAuthor[] $ommuBookAuthors
 * @property OmmuBookInterpreter[] $ommuBookInterpreters
 * @property OmmuBookMasterPublishers $publisher
 * @property OmmuBookReviews[] $ommuBookReviews
 * @property OmmuBookSubject[] $ommuBookSubjects
 */
class BookMasters extends CActiveRecord
{
	public $defaultColumns = array();
	public $old_cover;
	public $publisher_input;
	public $subject_input;
	public $author_input;
	public $interpreter_input;
	public $old_publisher_input;
	public $old_publisher_id;
	//book request 
	public $author_id;
	public $interpreter_id;
	
	// Variable Search
	public $publisher_search;
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BookMasters the static model class
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
		return 'ommu_book_masters';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required', 'on'=>'bookmaster'),
			array('
				publisher_input', 'required', 'on'=>'bookmaster, request'),
			array('
				author_input', 'required', 'on'=>'request'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('publish_year', 'length', 'max'=>4),
			array('publisher_id, creation_id, modified_id', 'length', 'max'=>11),
			array('publish_city, edition', 'length', 'max'=>32),
			array('isbn, cover, paging, sizes,
				publisher_input, subject_input, author_input, interpreter_input', 'length', 'max'=>64),
			array('title', 'length', 'max'=>128),
			array('publisher_id, isbn, description, cover, edition, publish_city, publish_year, paging, sizes, creation_date, creation_id, modified_date, modified_id,
				old_cover, publisher_input, subject_input, author_input, interpreter_input, old_publisher_input, old_publisher_id, author_id, interpreter_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('book_id, publish, publisher_id, isbn, title, description, cover, edition, publish_city, publish_year, paging, sizes, creation_date, creation_id, modified_date, modified_id,
				publisher_search, creation_search, modified_search', 'safe', 'on'=>'search'),
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
			'author' => array(self::HAS_MANY, 'BookAuthor', 'book_id'),
			'interpreter' => array(self::HAS_MANY, 'BookInterpreter', 'book_id'),
			'review' => array(self::HAS_MANY, 'BookReviews', 'book_id'),
			'subject' => array(self::HAS_MANY, 'BookSubject', 'book_id'),
			'publisher' => array(self::BELONGS_TO, 'BookMasterPublishers', 'publisher_id'),
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
			'book_id' => 'Book',
			'publish' => 'Publish',
			'publisher_id' => 'Publisher',
			'isbn' => 'Isbn',
			'title' => 'Title',
			'description' => 'Description',
			'cover' => 'Cover',
			'edition' => 'Edition',
			'publish_city' => 'Publish City',
			'publish_year' => 'Publish Year',
			'paging' => 'Paging',
			'sizes' => 'Sizes',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'publisher_search' => 'Publisher',
			'creation_search' => 'Creation',
			'modified_search' => 'Modified',
			'old_cover' => 'Old Cover',
			'publisher_input' => 'Publisher',
			'subject_input' => 'Subject',
			'author_input' => 'Author',
			'interpreter_input' => 'Interpreter',
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

		$criteria->compare('t.book_id',$this->book_id,true);
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
		if(isset($_GET['publisher'])) {
			$criteria->compare('t.publisher_id',$_GET['publisher']);
		} else {
			$criteria->compare('t.publisher_id',$this->publisher_id);
		}
		$criteria->compare('t.isbn',$this->isbn,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.cover',$this->cover,true);
		$criteria->compare('t.edition',$this->edition,true);
		$criteria->compare('t.publish_city',$this->publish_city,true);
		$criteria->compare('t.publish_year',$this->publish_year,true);
		$criteria->compare('t.paging',$this->paging,true);
		$criteria->compare('t.sizes',$this->sizes,true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id',$this->creation_id,true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id',$this->modified_id,true);
		
		// Custom Search
		$criteria->with = array(
			'publisher' => array(
				'alias'=>'publisher',
				'select'=>'publisher_name'
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
		$criteria->compare('publisher.publisher_name',strtolower($this->publisher_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['BookMasters_sort']))
			$criteria->order = 'book_id DESC';

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
			//$this->defaultColumns[] = 'book_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'publisher_id';
			$this->defaultColumns[] = 'isbn';
			$this->defaultColumns[] = 'title';
			$this->defaultColumns[] = 'description';
			$this->defaultColumns[] = 'cover';
			$this->defaultColumns[] = 'edition';
			$this->defaultColumns[] = 'publish_city';
			$this->defaultColumns[] = 'publish_year';
			$this->defaultColumns[] = 'paging';
			$this->defaultColumns[] = 'sizes';
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
				'name' => 'title',
				'value' => '$data->title."<br/><span>".Utility::shortText(Utility::hardDecode($data->description),200)."</span>"',
				'htmlOptions' => array(
					'class' => 'bold',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = 'isbn';
			$this->defaultColumns[] = array(
				'name' => 'publisher_search',
				'value' => '$data->publisher->publisher_name',
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
				'name' => 'creation_search',
				'value' => '$data->creation->displayname',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->book_id)), $data->publish, 1)',
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
			$controller = strtolower(Yii::app()->controller->id);
			if($this->isNewRecord) {
				$this->creation_id = Yii::app()->user->id;			
			} else {
				$this->modified_id = Yii::app()->user->id;					
			}
			
			$cover = CUploadedFile::getInstance($this, 'cover');
			if($cover->name != '') {
				$extension = pathinfo($cover->name, PATHINFO_EXTENSION);
				if(!in_array($extension, array('bmp','gif','jpg','png')))
					$this->addError('cover', 'The file "'.$cover->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
			}
			
			if($controller == 'request') {
				if($this->author_id == 0)
					$this->author_id = '';
				if($this->interpreter_id == 0)
					$this->interpreter_id = '';
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->title = strtolower($this->title);
			$this->publish_city = strtolower($this->publish_city);
			
			if(($this->isNewRecord && ($this->publisher_id == '' && $this->publisher_input != '')) || (!$this->isNewRecord && (($this->publisher_id == $this->old_publisher_id) && ($this->publisher_input != $this->old_publisher_input)))) {
				$model = BookMasterPublishers::model()->find(array(
					'select' => 'publisher_id, publisher_name',
					'condition' => 'publish = 1 AND publisher_name = :name',
					'params' => array(
						':name' => strtolower($this->publisher_input),
					),
				));
				if($model != null) {
					$this->publisher_id = $model->publisher_id;
				} else {
					$publisher = new BookMasterPublishers;
					$publisher->publisher_name = $this->publisher_input;
					if($publisher->save()) {
						$this->publisher_id = $publisher->publisher_id;
					}
				}
			}
			
			if(!$this->isNewRecord) {
				//Update book photo
				$book_path = "public/book/book/";
				
				$this->cover = CUploadedFile::getInstance($this, 'cover');
				if($this->cover instanceOf CUploadedFile) {
					$fileName = $this->book_id.'_'.time().'.'.strtolower($this->cover->extensionName);
					if($this->cover->saveAs($book_path.'/'.$fileName)) {
						if($this->old_cover != '')
							rename($book_path.'/'.$this->old_cover, 'public/book/verwijderen/book_'.$this->old_cover);
						$this->cover = $fileName;
					}
				}
					
				if($this->cover == '') {
					$this->cover = $this->old_cover;
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
			
		//Update book photo
		$controller = strtolower(Yii::app()->controller->id);
		if($this->isNewRecord) {
			$book_path = "public/book/book/";
			
			$this->cover = CUploadedFile::getInstance($this, 'cover');
			if($this->cover instanceOf CUploadedFile) {
				$fileName = $this->book_id.'_'.time().'.'.strtolower($this->cover->extensionName);
				if($this->cover->saveAs($book_path.'/'.$fileName)) {
					BookMasters::model()->updateByPk($this->book_id, array('cover'=>$fileName));
				}
			}
			
			if($controller == 'request') {
				//author and interpreter
				if($this->author_id != '' || $this->author_id != 0) {
					$author=new BookAuthor;
					$author->book_id = $this->book_id;
					$author->author_id = $this->author_id;
					$author->save();
				} else {
					if($this->author_input != '') {
						$model = BookMasterAuthors::model()->find(array(
							'select' => 'author_id, author_name',
							'condition' => 'publish = 1 AND author_name = :name',
							'params' => array(
								':name' => strtolower($this->author_input),
							),
						));
						$author = new BookAuthor;
						$author->book_id = $this->book_id;
						if($model != null) {
							$author->author_id = $model->author_id;
							$author->save();
						} else {
							$data = new BookMasterAuthors;
							$data->author_name = $this->author_input;
							if($data->save()) {
								$author->author_id = $data->author_id;
								$author->save();
							}
						}
					}
				}
				if($this->interpreter_id != '' || $this->interpreter_id != 0) {
					$interpreter=new BookInterpreter;
					$interpreter->book_id = $this->book_id;
					$interpreter->interpreter_id = $this->interpreter_id;
					$interpreter->save();				
				} else {
					if($this->interpreter_input != '') {
						$model = BookMasterAuthors::model()->find(array(
							'select' => 'author_id, author_name',
							'condition' => 'publish = 1 AND author_name = :name',
							'params' => array(
								':name' => strtolower($this->interpreter_input),
							),
						));
						$interpreter = new BookInterpreter;
						$interpreter->book_id = $this->book_id;
						if($model != null) {
							$interpreter->interpreter_id = $model->author_id;
							$interpreter->save();
						} else {
							$data = new BookMasterAuthors;
							$data->author_name = $this->interpreter_input;
							if($data->save()) {
								$interpreter->interpreter_id = $data->author_id;
								$interpreter->save();
							}
						}
					}					
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
		$book_path = "public/book/book/";
		if($this->cover != '')
			rename($book_path.'/'.$this->cover, 'public/book/verwijderen/book_'.$this->cover);
	}

}