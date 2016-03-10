<?php
/**
 * RecruitmentEventUser
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:49 WIB
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
 * This is the model class for table "ommu_recruitment_event_user".
 *
 * The followings are the available columns in table 'ommu_recruitment_event_user':
 * @property string $event_user_id
 * @property integer $publish
 * @property string $recruitment_id
 * @property string $user_id
 * @property string $salt
 * @property string $test_number
 * @property string $password
 * @property string $major
 * @property string $creation_date
 * @property string $creation_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitments $recruitment
 * @property OmmuRecruitmentUsers $user
 */
class RecruitmentEventUser extends CActiveRecord
{
	public $defaultColumns = array();
	public $newPassword;
	public $confirmPassword;
	
	// Variable Search
	public $recruitment_search;
	public $user_search;
	public $creation_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecruitmentEventUser the static model class
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
		return 'ommu_recruitment_event_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, recruitment_id, user_id, test_number, major', 'required'),
			array('publish', 'numerical', 'integerOnly'=>true),
			array('
				newPassword, confirmPassword', 'required', 'on'=>'formAdd'),
			array('recruitment_id, user_id, creation_id', 'length', 'max'=>11),
			array('salt, test_number, password, major', 'length', 'max'=>32),
			//array('test_number', 'match', 'pattern' => '/^[a-zA-Z0-9_.-]{0,25}$/', 'message' => Yii::t('other', 'Nama user hanya boleh berisi karakter, angka dan karakter (., -, _)')),
			array('test_number, major,
				newPassword, confirmPassword', 'safe'),
			array('
				newPassword', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Kedua password tidak sama2.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('event_user_id, publish, recruitment_id, user_id, salt, test_number, password, major, creation_date, creation_id,
				recruitment_search, user_search, creation_search', 'safe', 'on'=>'search'),
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
			'recruitment' => array(self::BELONGS_TO, 'Recruitments', 'recruitment_id'),
			'user' => array(self::BELONGS_TO, 'RecruitmentUsers', 'user_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'event_user_id' => 'Event User Id',
			'publish' => 'Publish',
			'recruitment_id' => 'Recruitment',
			'user_id' => 'User',
			'salt' => 'Salt',
			'test_number' => 'Test Number',
			'password' => 'Password',
			'major' => 'Major',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'newPassword' => 'Password',
			'confirmPassword' => 'Confirm Password',
			'recruitment_search' => 'Recruitment',
			'user_search' => 'User',
			'creation_search' => 'Creation',
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

		$criteria->compare('t.event_user_id',strtolower($this->event_user_id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['recruitment']))
			$criteria->compare('t.recruitment_id',$_GET['recruitment']);
		else
			$criteria->compare('t.recruitment_id',$this->recruitment_id);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.salt',strtolower($this->salt),true);
		$criteria->compare('t.test_number',strtolower($this->test_number),true);
		$criteria->compare('t.password',strtolower($this->password),true);
		$criteria->compare('t.major',strtolower($this->major),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		
		// Custom Search
		$criteria->with = array(
			'recruitment' => array(
				'alias'=>'recruitment',
				'select'=>'event_name'
			),
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
		);
		$criteria->compare('recruitment.event_name',strtolower($this->recruitment_search), true);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);

		if(!isset($_GET['RecruitmentEventUser_sort']))
			$criteria->order = 't.event_user_id DESC';

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
			//$this->defaultColumns[] = 'event_user_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'recruitment_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'salt';
			$this->defaultColumns[] = 'test_number';
			$this->defaultColumns[] = 'password';
			$this->defaultColumns[] = 'major';
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
				'name' => 'event_user_id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'recruitment_search',
				'value' => '$data->recruitment->event_name',
			);
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
			);
			$this->defaultColumns[] = 'test_number';
			$this->defaultColumns[] = 'major';
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
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->id)), $data->publish, 1)',
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
	 * User salt codes
	 */
	public static function getUniqueCode() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$salt = '' ;

		while ($i <= 15) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$salt = $salt . $tmp; 
			$i++;
		}

		return $salt;
	}

	/**
	 * User generate password
	 */
	public static function getGeneratePassword() {
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		srand((double)microtime()*1000000);
		$i = 0;
		$password = '' ;

		while ($i <= 4) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 2);
			$password = $password . $tmp; 
			$i++;
		}

		return $password;
	}

	/**
	 * User Salt
	 */
	public static function hashPassword($salt, $password)
	{
		return md5($salt.$password);
	}
	
	public static function insertUser($recruitment_id, $user_id, $test_number, $password, $major) 
	{
		$return = true;
		
		$model=new RecruitmentEventUser;
		$model->recruitment_id = $recruitment_id;
		$model->user_id = $user_id;
		$model->test_number = $test_number;
		$model->newPassword = $password;
		$model->major = $major;
		
		if($model->save())
			$return = $model->event_user_id;
		return $return;
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			$controller = strtolower(Yii::app()->controller->id);
			$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
			
			if($this->isNewRecord) {
				$this->salt = self::getUniqueCode();
				if($currentAction == 'o/batch/import') {
					if($this->newPassword == '')
						$this->confirmPassword = $this->newPassword = self::getGeneratePassword();
					else
						$this->confirmPassword = $this->newPassword;
				}
				$this->creation_id = Yii::app()->user->id;				
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->test_number = strtolower($this->test_number);
			$this->password = self::hashPassword($this->salt, $this->newPassword);
		}
		return true;	
	}

}