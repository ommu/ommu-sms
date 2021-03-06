<?php
/**
 * ViewSmsOutbox
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 15 February 2016, 11:40 WIB
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
 * This is the model class for table "_view_sms_outbox".
 *
 * The followings are the available columns in table '_view_sms_outbox':
 * @property integer $outbox_id
 * @property integer $status
 * @property string $group_id
 * @property string $smsc_source
 * @property string $destination_nomor
 * @property string $message
 * @property string $sents
 * @property string $creation_date
 * @property string $creation_id
 * @property string $updated_date
 * @property string $noted
 */
class ViewSmsOutbox extends CActiveRecord
{
	use GridViewTrait;

	public $defaultColumns = array();
	
	// Variable Search
	public $creation_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewSmsOutbox the static model class
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
		return '_view_sms_outbox';
	}

	/**
	 * @return string the primarykey column
	 */
	public function primaryKey()
	{
		return 'outbox_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, smsc_source, destination_nomor, message, creation_id, noted', 'required'),
			array('outbox_id, status', 'numerical', 'integerOnly'=>true),
			array('group_id, creation_id', 'length', 'max'=>11),
			array('smsc_source, destination_nomor', 'length', 'max'=>15),
			array('sents', 'length', 'max'=>21),
			array('noted', 'length', 'max'=>64),
			array('creation_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('outbox_id, status, group_id, smsc_source, destination_nomor, message, sents, creation_date, creation_id, updated_date, noted,
				creation_search', 'safe', 'on'=>'search'),
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
			'creation_TO' => array(self::BELONGS_TO, 'Users', 'creation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'outbox_id' => Yii::t('attribute', 'Outbox'),
			'status' => Yii::t('attribute', 'Status'),
			'group_id' => Yii::t('attribute', 'Group'),
			'smsc_source' => Yii::t('attribute', 'Smsc Source'),
			'destination_nomor' => Yii::t('attribute', 'Destination Nomor'),
			'message' => Yii::t('attribute', 'Message'),
			'sents' => Yii::t('attribute', 'Penerima'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'updated_date' => Yii::t('attribute', 'Updated Date'),
			'noted' => Yii::t('attribute', 'Noted'),
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

		$criteria->compare('t.outbox_id', $this->outbox_id);
		$criteria->compare('t.status', $this->status);
		if(Yii::app()->getRequest()->getParam('group'))
			$criteria->compare('t.group_id', Yii::app()->getRequest()->getParam('group'));
		else
			$criteria->compare('t.group_id', $this->group_id);
		$criteria->compare('t.smsc_source', strtolower($this->smsc_source), true);
		$criteria->compare('t.destination_nomor', strtolower($this->destination_nomor), true);
		$criteria->compare('t.message', strtolower($this->message), true);
		$criteria->compare('t.sents', strtolower($this->sents), true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.updated_date)', date('Y-m-d', strtotime($this->updated_date)));
		$criteria->compare('t.noted', strtolower($this->noted), true);

		if(!Yii::app()->getRequest()->getParam('ViewSmsOutbox_sort'))
			$criteria->order = 't.outbox_id DESC';

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
			$this->defaultColumns[] = 'outbox_id';
			$this->defaultColumns[] = 'status';
			$this->defaultColumns[] = 'group_id';
			$this->defaultColumns[] = 'smsc_source';
			$this->defaultColumns[] = 'destination_nomor';
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = 'sents';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'updated_date';
			$this->defaultColumns[] = 'noted';
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
			$this->defaultColumns[] = array(
				'name' => 'destination_nomor',
				'value' => '$data->noted != "" ? $data->noted : $data->destination_nomor',
			);
			$this->defaultColumns[] = 'message';
			$this->defaultColumns[] = array(
				'name' => 'sents',
				'value' => 'CHtml::link($data->sents." contact", Yii::app()->controller->createUrl("o/sentitem/manage", array("group"=>$data->group_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_search',
				'value' => '$data->creation_TO->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'creation_date'),
			);
			$this->defaultColumns[] = array(
				'name' => 'status',
				'value' => '$data->status == 0 ? "Pending" : ($data->status == 1 ? "Sent" : ($data->status == 2 ? "Failed" : "Delivered"))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' =>array(
					0=>'Pending',
					1=>'Sent',
					2=>'Failed',
					3=>'Delivered',
				),
				'type' => 'raw',
			);
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

}