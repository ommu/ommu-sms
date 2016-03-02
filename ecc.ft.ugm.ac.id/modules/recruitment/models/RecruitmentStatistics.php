<?php
/**
 * RecruitmentStatistics
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:50 WIB
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
 * This is the model class for table "ommu_recruitment_statistics".
 *
 * The followings are the available columns in table 'ommu_recruitment_statistics':
 * @property string $date_key
 * @property string $recruitment_insert
 * @property string $recruitment_update
 * @property string $recruitment_delete
 * @property string $session_insert
 * @property string $session_update
 * @property string $session_delete
 * @property string $register_from_public
 * @property string $register_from_admin
 * @property string $user_update_info
 * @property string $user_update_by_admin
 * @property string $admin_block_user
 * @property string $admin_unblock_user
 * @property string $admin_drop_user
 * @property string $event_user_insert
 * @property string $event_user_delete
 * @property string $session_user_insert
 * @property string $session_user_delete
 */
class RecruitmentStatistics extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecruitmentStatistics the static model class
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
		return 'ommu_recruitment_statistics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_key', 'required'),
			array('recruitment_insert, recruitment_update, recruitment_delete, session_insert, session_update, session_delete, register_from_public, register_from_admin, user_update_info, user_update_by_admin, admin_block_user, admin_unblock_user, admin_drop_user, event_user_insert, event_user_delete, session_user_insert, session_user_delete', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('date_key, recruitment_insert, recruitment_update, recruitment_delete, session_insert, session_update, session_delete, register_from_public, register_from_admin, user_update_info, user_update_by_admin, admin_block_user, admin_unblock_user, admin_drop_user, event_user_insert, event_user_delete, session_user_insert, session_user_delete', 'safe', 'on'=>'search'),
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
			'date_key' => 'Date Key',
			'recruitment_insert' => 'Recruitment Insert',
			'recruitment_update' => 'Recruitment Update',
			'recruitment_delete' => 'Recruitment Delete',
			'session_insert' => 'Session Insert',
			'session_update' => 'Session Update',
			'session_delete' => 'Session Delete',
			'register_from_public' => 'Register From Public',
			'register_from_admin' => 'Register From Admin',
			'user_update_info' => 'User Update Info',
			'user_update_by_admin' => 'User Update By Admin',
			'admin_block_user' => 'Admin Block User',
			'admin_unblock_user' => 'Admin Unblock User',
			'admin_drop_user' => 'Admin Drop User',
			'event_user_insert' => 'Event User Insert',
			'event_user_delete' => 'Event User Delete',
			'session_user_insert' => 'Session User Insert',
			'session_user_delete' => 'Session User Delete',
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

		if($this->date_key != null && !in_array($this->date_key, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.date_key)',date('Y-m-d', strtotime($this->date_key)));
		$criteria->compare('t.recruitment_insert',strtolower($this->recruitment_insert),true);
		$criteria->compare('t.recruitment_update',strtolower($this->recruitment_update),true);
		$criteria->compare('t.recruitment_delete',strtolower($this->recruitment_delete),true);
		$criteria->compare('t.session_insert',strtolower($this->session_insert),true);
		$criteria->compare('t.session_update',strtolower($this->session_update),true);
		$criteria->compare('t.session_delete',strtolower($this->session_delete),true);
		$criteria->compare('t.register_from_public',strtolower($this->register_from_public),true);
		$criteria->compare('t.register_from_admin',strtolower($this->register_from_admin),true);
		$criteria->compare('t.user_update_info',strtolower($this->user_update_info),true);
		$criteria->compare('t.user_update_by_admin',strtolower($this->user_update_by_admin),true);
		$criteria->compare('t.admin_block_user',strtolower($this->admin_block_user),true);
		$criteria->compare('t.admin_unblock_user',strtolower($this->admin_unblock_user),true);
		$criteria->compare('t.admin_drop_user',strtolower($this->admin_drop_user),true);
		$criteria->compare('t.event_user_insert',strtolower($this->event_user_insert),true);
		$criteria->compare('t.event_user_delete',strtolower($this->event_user_delete),true);
		$criteria->compare('t.session_user_insert',strtolower($this->session_user_insert),true);
		$criteria->compare('t.session_user_delete',strtolower($this->session_user_delete),true);

		if(!isset($_GET['RecruitmentStatistics_sort']))
			$criteria->order = 't.date_key DESC';

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
			//$this->defaultColumns[] = 'date_key';
			$this->defaultColumns[] = 'recruitment_insert';
			$this->defaultColumns[] = 'recruitment_update';
			$this->defaultColumns[] = 'recruitment_delete';
			$this->defaultColumns[] = 'session_insert';
			$this->defaultColumns[] = 'session_update';
			$this->defaultColumns[] = 'session_delete';
			$this->defaultColumns[] = 'register_from_public';
			$this->defaultColumns[] = 'register_from_admin';
			$this->defaultColumns[] = 'user_update_info';
			$this->defaultColumns[] = 'user_update_by_admin';
			$this->defaultColumns[] = 'admin_block_user';
			$this->defaultColumns[] = 'admin_unblock_user';
			$this->defaultColumns[] = 'admin_drop_user';
			$this->defaultColumns[] = 'event_user_insert';
			$this->defaultColumns[] = 'event_user_delete';
			$this->defaultColumns[] = 'session_user_insert';
			$this->defaultColumns[] = 'session_user_delete';
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
			$this->defaultColumns[] = 'recruitment_insert';
			$this->defaultColumns[] = 'recruitment_update';
			$this->defaultColumns[] = 'recruitment_delete';
			$this->defaultColumns[] = 'session_insert';
			$this->defaultColumns[] = 'session_update';
			$this->defaultColumns[] = 'session_delete';
			$this->defaultColumns[] = 'register_from_public';
			$this->defaultColumns[] = 'register_from_admin';
			$this->defaultColumns[] = 'user_update_info';
			$this->defaultColumns[] = 'user_update_by_admin';
			$this->defaultColumns[] = 'admin_block_user';
			$this->defaultColumns[] = 'admin_unblock_user';
			$this->defaultColumns[] = 'admin_drop_user';
			$this->defaultColumns[] = 'event_user_insert';
			$this->defaultColumns[] = 'event_user_delete';
			$this->defaultColumns[] = 'session_user_insert';
			$this->defaultColumns[] = 'session_user_delete';
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
	/*
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			// Create action
		}
		return true;
	}
	*/

	/**
	 * after validate attributes
	 */
	/*
	protected function afterValidate()
	{
		parent::afterValidate();
			// Create action
		return true;
	}
	*/
	
	/**
	 * before save attributes
	 */
	/*
	protected function beforeSave() {
		if(parent::beforeSave()) {
		}
		return true;	
	}
	*/
	
	/**
	 * After save attributes
	 */
	/*
	protected function afterSave() {
		parent::afterSave();
		// Create action
	}
	*/

	/**
	 * Before delete attributes
	 */
	/*
	protected function beforeDelete() {
		if(parent::beforeDelete()) {
			// Create action
		}
		return true;
	}
	*/

	/**
	 * After delete attributes
	 */
	/*
	protected function afterDelete() {
		parent::afterDelete();
		// Create action
	}
	*/

}