<?php
/**
 * RecruitmentSessionUser
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
 * This is the model class for table "ommu_recruitment_session_user".
 *
 * The followings are the available columns in table 'ommu_recruitment_session_user':
 * @property string $id
 * @property integer $publish
 * @property string $user_id
 * @property string $event_user_id
 * @property string $session_id
 * @property string $session_seat
 * @property string $sendemail_status
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitmentUsers $user
 * @property OmmuRecruitmentSessions $session
 */
class RecruitmentSessionUser extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $email_search;
	public $user_search;
	public $session_search;
	public $creation_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RecruitmentSessionUser the static model class
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
		return 'ommu_recruitment_session_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, user_id, event_user_id, session_id, session_seat', 'required'),
			array('id, publish, creation_id, sendemail_status', 'numerical', 'integerOnly'=>true),
			array('user_id, event_user_id, session_id', 'length', 'max'=>11),
			array('session_seat', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, publish, user_id, event_user_id, session_id, session_seat, sendemail_status, creation_date, creation_id,
				email_search, user_search, session_search, creation_search', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'RecruitmentUsers', 'user_id'),
			'eventUser' => array(self::BELONGS_TO, 'RecruitmentEventUser', 'event_user_id'),
			'session' => array(self::BELONGS_TO, 'RecruitmentSessions', 'session_id'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'publish' => 'Publish',
			'user_id' => 'User',
			'event_user_id' => 'Event User',
			'session_id' => 'Session',
			'session_seat' => 'Session Seat',
			'sendemail_status' => 'Send Email',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'email_search' => 'Email',
			'user_search' => 'User',
			'session_search' => 'Session',
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

		$criteria->compare('t.id',strtolower($this->id),true);
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
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		if(isset($_GET['eventuser']))
			$criteria->compare('t.event_user_id',$_GET['eventuser']);
		else
			$criteria->compare('t.event_user_id',$this->event_user_id);
		if(isset($_GET['session'])) {
			$session = RecruitmentSessions::model()->findByPk($_GET['session'],array(
				'select' => 'session_id, parent_id'
			));
			if($session->parent_id == 0) {
				$batch = RecruitmentSessions::model()->findAll(array(
					'condition' => 'publish = :publish AND parent_id = :parent',
					'params' => array(
						':publish' => 1,
						':parent' => $_GET['session'],
					),
				));
				$items = array();
				if($batch != null) {
					foreach($batch as $key => $val)
						$items[] = $val->session_id;
				}
				$criteria->addInCondition('t.session_id',$items);
				
			} else 
				$criteria->compare('t.session_id',$_GET['session']);			
		} else
			$criteria->compare('t.session_id',$this->session_id);
		$criteria->compare('t.session_seat',strtolower($this->session_seat),true);
		$criteria->compare('t.sendemail_status',strtolower($this->sendemail_status),true);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		
		// Custom Search
		$criteria->with = array(
			'user' => array(
				'alias'=>'user',
				'select'=>'email, displayname'
			),
			'session' => array(
				'alias'=>'session',
				'select'=>'session_name'
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
		);
		$criteria->compare('user.email',strtolower($this->email_search), true);
		$criteria->compare('user.displayname',strtolower($this->user_search), true);
		$criteria->compare('session.session_name',strtolower($this->session_search), true);
		$criteria->compare('creation.displayname',strtolower($this->creation_search), true);

		if(!isset($_GET['RecruitmentSessionUser_sort']))
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
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'event_user_id';
			$this->defaultColumns[] = 'session_id';
			$this->defaultColumns[] = 'session_seat';
			$this->defaultColumns[] = 'sendemail_status';
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
			$this->defaultColumns[] = array(
				'name' => 'user_search',
				'value' => '$data->user->displayname',
			);
			$this->defaultColumns[] = array(
				'name' => 'email_search',
				'value' => '$data->user->email',
			);
			$this->defaultColumns[] = array(
				'name' => 'session_search',
				'value' => '$data->session->session_name',
			);
			$this->defaultColumns[] = 'session_seat';
			/*
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
			*/
			$this->defaultColumns[] = array(
				'header' => 'Send Email',
				'value' => 'CHtml::link("Send Email", Yii::app()->controller->createUrl("o/sessionuser/sendemail",array("id"=>$data->id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'sendemail_status',
					'value' => '$data->sendemail_status == 1 ? Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : Chtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'type' => 'raw',
				);
			}
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
	
	public static function insertUser($user_id, $event_user_id, $session_id, $session_seat) 
	{
		$return = true;
		
		$model=new RecruitmentSessionUser;		
		$model->user_id = $user_id;
		$model->event_user_id = $event_user_id;
		$model->session_id = $session_id;
		$model->session_seat = $session_seat;
		if($model->save())
			$return = $model->id;
		
		return $return;
	}
	
	/**
	 * Create pdf, save to disk and return the name with path
	 */
	public function getPdf($model, $preview=false, $template=null, $path=null, $documentName=null, $page=null) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		Yii::import('ext.html2pdf.HTML2PDF');
		Yii::import('ext.html2pdf._mypdf.MyPDF');	// classe mypdf
		Yii::import('ext.html2pdf.parsingHTML');	// classe de parsing HTML
		Yii::import('ext.html2pdf.styleHTML');		// classe de gestion des styles
		
		if($template == null)
			$template = 'pln_cdugm19_pdf';
		
		include(YiiBase::getPathOfAlias('webroot.externals.recruitment.template').'/'.$template.'.php');		
		$content  = ob_get_clean();
		$fileName = '';
		
		try {
			// initialisation de HTML2PDF
			if($page == null)
				$page = 'P';
			$html2pdf = new HTML2PDF($page,'A4','en', false, 'ISO-8859-15', array(0, 0, 0, 0));

			// affichage de la page en entier
			$html2pdf->pdf->SetDisplayMode('fullpage');

			// conversion
			$html2pdf->writeHTML($content);
			
			if($path == null)
				$path = YiiBase::getPathOfAlias('webroot.public.recruitment.user_pdf');
			if($documentName == null)
				$documentName = Utility::getUrlTitle($model->eventUser->test_number.' '.$model->user->displayname);
			
			$fileName = $path.'/'.time().'_'.$documentName.'.pdf';
			
			if($preview == false)
				$html2pdf->Output($fileName, 'F');
			else
				$html2pdf->Output($fileName);
			@chmod($fileName, 0777);
			
		} catch(HTML2PDF_exception $e) {
			echo $e;
		}
		
		ob_end_flush();
		return $fileName;
	}
        
        
	/**
	 * Create pdf, save to disk and return the name with path
	 */
	public function getPdfParticipantCard($models, $developerMode=true) 
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		Yii::import('ext.html2pdf.HTML2PDF');
		Yii::import('ext.html2pdf._mypdf.MyPDF');	// classe mypdf
		Yii::import('ext.html2pdf.parsingHTML');	// classe de parsing HTML
		Yii::import('ext.html2pdf.styleHTML');		// classe de gestion des styles
		
		$template = 'pln_cdugm19_participant_card';
		include(YiiBase::getPathOfAlias('webroot.externals.recruitment.template').'/'.$template.'.php');		
		$content  = ob_get_clean();
		$fileName = '';
		
		try {
			// initialisation de HTML2PDF
			$html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15', array(0, 0, 0, 0));

			// affichage de la page en entier
			$html2pdf->pdf->SetDisplayMode('fullpage');

			// conversion
			$html2pdf->writeHTML($content);

			// envoie du PDF
			
			//$fileName = YiiBase::getPathOfAlias('webroot.public.recruitment.user_pdf').'/'.time().'_'.Utility::getUrlTitle($model->eventUser->test_number.' '.$model->user->displayname).'_participant_card.pdf';
			$fileName = YiiBase::getPathOfAlias('webroot.public.recruitment.user_pdf').'/'.time().'_'.'_participant_cardxx.pdf';
			if($developerMode == true)
				$html2pdf->Output($fileName, 'F');
			else
				$html2pdf->Output($fileName);
			@chmod($fileName, 0777);
			
		} catch(HTML2PDF_exception $e) {
			echo $e;
		}
		
		ob_end_flush();
		return $fileName;
	}
	
	/**
	 * 
	 * @param type $sessionid
	 * @param type $type
	 * @param type $w
	 * @param type $h
	 */
	public function generateBarcodeParticipant($sessionid, $typeBarcode = 'upca', $widthBarcode=2, $hightBarcode=30) {
		
		$criteria=new CDbCriteria;            
		$criteria->compare('t.publish',1);
		$criteria->compare('t.session_id', $sessionid);    

		$model = RecruitmentSessionUser::model()->findAll($criteria);
		
		Yii::import('ext.php-barcodes.DNS1DBarcode');	
		foreach($model as $val) {			
			$text = str_pad($val->session->recruitment_id, 2, '0', STR_PAD_LEFT).''.str_pad($val->session_id, 3, '0', STR_PAD_LEFT).''.str_pad($val->user_id, 6, '0', STR_PAD_LEFT);
			
			$barcode = new DNS1DBarcode();
			$pathFolder = YiiBase::getPathOfAlias('webroot.public.recruitment.user_barcode_'.$typeBarcode).'/';
			if(!file_exists($pathFolder)){
							mkdir($pathFolder, 0777);
							chmod($pathFolder, 0777);
			}
			$barcode->save_path=$pathFolder;
			$barcode->getBarcodePNGPath($text, $typeBarcode, $widthBarcode, $hightBarcode);               
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			$this->creation_id = Yii::app()->user->id;
		}
		return true;
	}
}