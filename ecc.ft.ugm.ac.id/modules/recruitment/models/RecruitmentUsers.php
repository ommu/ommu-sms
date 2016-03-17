<?php
/**
 * RecruitmentUsers
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:48 WIB
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
 * This is the model class for table "ommu_recruitment_users".
 *
 * The followings are the available columns in table 'ommu_recruitment_users':
 * @property string $user_id
 * @property integer $enabled
 * @property string $salt
 * @property string $email
 * @property string $password
 * @property string $displayname
 * @property string $photos
 * @property string $major
 * @property string $creation_date
 * @property string $creation_ip
 * @property string $update_date
 * @property string $update_ip
 * @property string $lastlogin_date
 * @property string $lastlogin_ip
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitmentEventUser[] $ommuRecruitmentEventUsers
 * @property OmmuRecruitmentSessionUser[] $ommuRecruitmentSessionUsers
 */
class RecruitmentUsers extends CActiveRecord
{
	public $defaultColumns = array();
	public $newPassword;
	public $confirmPassword;
	public $oldPhoto;
	
	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecruitmentUsers the static model class
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
		return 'ommu_recruitment_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('enabled, displayname, major', 'required'),
			array('email', 'required', 'on'=>'adminform, formEdit'),
			array('
				newPassword, confirmPassword', 'required', 'on'=>'adminform'),
			array('enabled, modified_id', 'numerical', 'integerOnly'=>true),
			array('creation_ip, update_ip, lastlogin_ip', 'length', 'max'=>20),
			array('salt, password', 'length', 'max'=>32),
			array('displayname, email', 'length', 'max'=>64),
			array('email,
				newPassword, confirmPassword, oldPhoto', 'safe'),
			array('
				newPassword', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Kedua password tidak sama2.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, enabled, salt, email, password, displayname, photos, major, creation_date, creation_ip, update_date, update_ip, lastlogin_date, lastlogin_ip, modified_date, modified_id, 
				modified_search', 'safe', 'on'=>'search'),
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
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'eventUser' => array(self::HAS_MANY, 'RecruitmentEventUser', 'user_id'),
			'sessionUser' => array(self::HAS_MANY, 'RecruitmentSessionUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'enabled' => 'Enabled',
			'salt' => 'Salt',
			'email' => 'Email',
			'password' => 'Password',
			'displayname' => 'Display Name',
			'photos' => 'Photos',
			'major' => 'Major',
			'creation_date' => 'Creation Date',
			'creation_ip' => 'Creation Ip',
			'update_date' => 'Update Date',
			'update_ip' => 'Update Ip',
			'lastlogin_date' => 'Lastlogin Date',
			'lastlogin_ip' => 'Lastlogin Ip',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
			'newPassword' => 'Password',
			'confirmPassword' => 'Confirm Password',
			'oldPhoto' => 'Old Photo',
			'modified_search' => 'Modified',
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

		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.enabled',$this->enabled);
		$criteria->compare('t.salt',strtolower($this->salt),true);
		$criteria->compare('t.email',strtolower($this->email),true);
		$criteria->compare('t.password',strtolower($this->password),true);
		$criteria->compare('t.displayname',strtolower($this->displayname),true);
		$criteria->compare('t.photos',strtolower($this->photos),true);
		$criteria->compare('t.major',strtolower($this->major),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_ip',strtolower($this->creation_ip),true);
		if($this->update_date != null && !in_array($this->update_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.update_date)',date('Y-m-d', strtotime($this->update_date)));
		$criteria->compare('t.update_ip',strtolower($this->update_ip),true);
		if($this->lastlogin_date != null && !in_array($this->lastlogin_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.lastlogin_date)',date('Y-m-d', strtotime($this->lastlogin_date)));
		$criteria->compare('t.lastlogin_ip',strtolower($this->lastlogin_ip),true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);
		
		// Custom Search
		$criteria->with = array(
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);
		$criteria->compare('modified.displayname',strtolower($this->modified_search), true);

		if(!isset($_GET['RecruitmentUsers_sort']))
			$criteria->order = 't.user_id DESC';

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
			//$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'enabled';
			$this->defaultColumns[] = 'salt';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'password';
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'photos';
			$this->defaultColumns[] = 'major';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_ip';
			$this->defaultColumns[] = 'update_date';
			$this->defaultColumns[] = 'update_ip';
			$this->defaultColumns[] = 'lastlogin_date';
			$this->defaultColumns[] = 'lastlogin_ip';
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
			$this->defaultColumns[] = 'displayname';
			$this->defaultColumns[] = 'email';
			$this->defaultColumns[] = 'major';
			$this->defaultColumns[] = array(
				'name' => 'photos',
				'value' => '$data->photos != "" ? CHtml::link($data->photos, Yii::app()->request->baseUrl.\'/public/recruitment/\'.$data->photos, array(\'target\' => \'_blank\')) : "-"',
				'type' => 'raw',
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
				'name' => 'lastlogin_date',
				'value' => '!in_array($data->lastlogin_date, array("0000-00-00 00:00:00","1970-01-01 00:00:00")) ? Utility::dateFormat($data->lastlogin_date) : "-"',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'lastlogin_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'lastlogin_date_filter',
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
					'name' => 'enabled',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("enabled",array("id"=>$data->user_id)), $data->enabled, 1)',
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
	
	public static function insertUser($email, $password, $displayname, $major) 
	{
		$return = true;
		
		$model=new RecruitmentUsers;
		$model->email = $email;
		$model->major = $major;
		$model->newPassword = $password;
		$model->displayname = $displayname;
		if($model->save())
			$return = $model->user_id;
		
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
				$this->creation_ip = $_SERVER['REMOTE_ADDR'];
				$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : 0;
				
			} else {
				// Admin modify member
				if(in_array($currentAction, array('o/admin/edit','o/member/edit'))) {
					$this->modified_date = date('Y-m-d H:i:s');
					$this->modified_id = Yii::app()->user->id;
				} else {
					$this->update_date = date('Y-m-d H:i:s');
					$this->update_ip = $_SERVER['REMOTE_ADDR'];
				}
			}
				
			if($currentAction != 'o/batch/import') {
				$this->oldPhoto = $this->photos;			
				$photo = CUploadedFile::getInstance($this, 'photos');		
				if($photo->name != '') {
					$extension = pathinfo($photo->name, PATHINFO_EXTENSION);
					if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
						$this->addError('photos', 'The file "'.$photo->name.'" cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.');
				} else
					if($currentAction != 'o/users/edit')
						$this->addError('photos', 'User Photo cannot be blank.');
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
			$this->email = strtolower($this->email);
			$this->password = self::hashPassword($this->salt, $this->newPassword);
			
			//upload new photo
			$recruitment_path = "public/recruitment/user_photos";
			// Generate path directory
			if(!file_exists($recruitment_path)) {
				@mkdir($recruitment_path, 0755, true);

				// Add File in Article Folder (index.php)
				$newFile = $recruitment_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($recruitment_path, 0755, true);
			
			$this->photos = CUploadedFile::getInstance($this, 'photos');
			if($this->photos instanceOf CUploadedFile) {
				$fileName = time().'_'.Utility::getUrlTitle($this->displayname).'.'.strtolower($this->photos->extensionName);
				if($this->photos->saveAs($recruitment_path.'/'.$fileName)) {
					//create thumb image
					Yii::import('ext.phpthumb.PhpThumbFactory');
					$pageImg = PhpThumbFactory::create($recruitment_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
					$pageImg->resize(700);
					$pageImg->save($recruitment_path.'/'.$fileName);
					
					if(!$this->isNewRecord && $this->oldPhoto != '' && file_exists($recruitment_path.'/'.$this->oldPhoto))
						rename($recruitment_path.'/'.$this->oldPhoto, 'public/recruitment/verwijderen/'.$this->user_id.'_'.$this->oldPhoto);
					$this->photos = $fileName;
				}
			}
			
			if(!$this->isNewRecord && $this->photos == '')
				$this->photos = $this->oldPhoto;
		}
		return true;	
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() {
		parent::afterDelete();
		//delete recruitment image
		$recruitment_path = "public/recruitment/user_photos";
		if($this->photos != '' && file_exists($recruitment_path.'/'.$this->photos))
			rename($recruitment_path.'/'.$this->photos, 'public/recruitment/verwijderen/'.$this->user_id.'_'.$this->photos);
	}

}