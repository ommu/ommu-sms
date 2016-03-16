<?php
/**
 * ViewRecruitmentSessionBatch
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 13 March 2016, 02:05 WIB
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
 * This is the model class for table "_view_recruitment_session_batch".
 *
 * The followings are the available columns in table '_view_recruitment_session_batch':
 * @property string $batch_id
 * @property integer $session_id
 * @property string $batch_name
 * @property string $session_name
 * @property string $event_name
 * @property string $users
 * @property string $user_scan
 * @property string $user_notscan
 */
class ViewRecruitmentSessionBatch extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewRecruitmentSessionBatch the static model class
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
		return '_view_recruitment_session_batch';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'batch_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('batch_name', 'required'),
			array('session_id', 'numerical', 'integerOnly'=>true),
			array('batch_id', 'length', 'max'=>11),
			array('batch_name, session_name, event_name', 'length', 'max'=>32),
			array('users, user_scan, user_notscan', 'length', 'max'=>21),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('batch_id, session_id, batch_name, session_name, event_name, users, user_scan, user_notscan', 'safe', 'on'=>'search'),
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
			'session' => array(self::BELONGS_TO, 'RecruitmentSessions', 'session_id'),
			'batch' => array(self::BELONGS_TO, 'RecruitmentSessions', 'batch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batch_id' => 'Batch',
			'session_id' => 'Session',
			'batch_name' => 'Batch Name',
			'session_name' => 'Session Name',
			'event_name' => 'Event Name',
			'users' => 'Users',
			'user_scan' => 'User Scan',
			'user_notscan' => 'User Not Scan',
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

		$criteria->compare('t.batch_id',strtolower($this->batch_id),true);
		$criteria->compare('t.session_id',$this->session_id);
		$criteria->compare('t.batch_name',strtolower($this->batch_name),true);
		$criteria->compare('t.session_name',strtolower($this->session_name),true);
		$criteria->compare('t.event_name',strtolower($this->event_name),true);
		$criteria->compare('t.users',strtolower($this->users),true);
		$criteria->compare('t.user_scan',strtolower($this->user_scan),true);
		$criteria->compare('t.user_notscan',strtolower($this->user_notscan),true);

		if(!isset($_GET['ViewRecruitmentSessionBatch_sort']))
			$criteria->order = 't.batch_id DESC';

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
			$this->defaultColumns[] = 'batch_id';
			$this->defaultColumns[] = 'session_id';
			$this->defaultColumns[] = 'batch_name';
			$this->defaultColumns[] = 'session_name';
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'users';
			$this->defaultColumns[] = 'user_scan';
			$this->defaultColumns[] = 'user_notscan';
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
			$this->defaultColumns[] = 'batch_id';
			$this->defaultColumns[] = 'session_id';
			$this->defaultColumns[] = 'batch_name';
			$this->defaultColumns[] = 'session_name';
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'users';
			$this->defaultColumns[] = 'user_scan';
			$this->defaultColumns[] = 'user_notscan';
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
}