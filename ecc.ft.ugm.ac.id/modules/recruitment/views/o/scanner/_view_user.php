<div class="sep">
	<h3>User & Batch Information</h3>
	<?php 
	if($user->photos != '')
		$photo = Yii::app()->request->baseUrl.'/public/recruitment/user_photos/'.$user->photos;
	else
		$photo = Yii::app()->request->baseUrl.'/public/recruitment/recruitment_default.png';
	
	$this->widget('application.components.system.FDetailView', array(
		'data'=>array(
			'user'=>$user,
			'eventUser'=>$eventUser,
			'sessionActive'=>$sessionActive,
		),
		'attributes'=>array(
			array(
				'name'=>'photos',
				'value'=>'<img src="'.Utility::getTimThumb($photo, 300, 300, 3).'" alt="'.$user->displayname.'">',
				'type'=>'raw',
			),
			array(
				'name'=>'displayname',
				'value'=>$user->displayname,
			),
			array(
				'name'=>'email',
				'value'=>$user->email,
			),
			array(
				'name'=>'major',
				'value'=>$user->major,
			),
			array(
				'name'=>'test_number',
				'value'=>strtoupper($eventUser->test_number),
			),
			array(
				'name'=>'session_name',
				'value'=>$sessionActive != null ? '<strong>'.$sessionActive->session->session_name.'</strong>, '.$sessionActive->session->viewBatch->session_name.', '.$sessionActive->session->recruitment->event_name : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'session_date',
				'value'=>$sessionActive != null ? Utility::dateFormat($sessionActive->session->session_date).', '.date("H:i", strtotime($sessionActive->session->session_time_start))." - ".date("H:i", strtotime($sessionActive->session->session_time_finish)).' WIB' : '-',
			),
			array(
				'name'=>'session_seat',
				'value'=>$sessionActive != null ? $sessionActive->session_seat : '-',
			),
			
		),
	)); ?>
</div>