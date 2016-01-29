<?php
/**
 * Visit Request (visit-guest)
 * @var $this RequestController
 * @var $model VisitGuest
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 26 January 2016, 13:01 WIB
 * @link https://github.com/oMMuCo
 * @contect (+62)856-299-4114
 *
 */
	$action = strtolower(Yii::app()->controller->action->id);
	
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#VisitGuest_organization input[name="VisitGuest[organization]"]').live('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#organization').slideUp();
		} else {
			$('div#organization').slideDown();
		}
	});
EOP;
	$cs->registerScript('setting', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'visit-guest-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<fieldset>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>
	
	<?php if($action != 'reply') {?>
		<?php if($model->isNewRecord) {?>
			<div class="clearfix">
				<?php echo $form->labelEx($author,'name'); ?>
				<div class="desc">
					<?php echo $form->textField($author,'name',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($author,'name'); ?>
				</div>
			</div>
			
			<div class="clearfix">
				<?php echo $form->labelEx($author,'email'); ?>
				<div class="desc">
					<?php echo $form->textField($author,'email',array('maxlength'=>32,'class'=>'span-4')); ?>
					<?php echo $form->error($author,'email'); ?>
				</div>
			</div>
			
			<div class="clearfix">
				<?php echo $form->labelEx($author,'author_phone'); ?>
				<div class="desc">
					<?php echo $form->textField($author,'author_phone',array('maxlength'=>15,'class'=>'span-4')); ?>
					<?php echo $form->error($author,'author_phone'); ?>
				</div>
			</div>
			
		<?php } else {?>		
			<div class="clearfix">
				<label>Information</label>
				<div class="desc">
					<?php echo $model->author_TO->name;?><br/>
					<a href="mailto:<?php echo $model->author_TO->email;?>" title="<?php echo $model->author_TO->email;?>"><?php echo $model->author_TO->email;?></a><br/>
					<?php 
					$contact = $model->author_TO->contact_MANY;
					if($contact != null) {
						foreach($contact as $data) {
							$type = "";
							if($data->type == 1)
								$type = "Mobile";
							else if($data->type == 2)
								$type = "Blackberry Messenger";
							else if($data->type == 3)
								$type = "Google Talk";
							else if($data->type == 4)
								$type = "Yahoo! Messenger";
							else if($data->type == 5)
								$type = "Windows Live Messenger";
							else if($data->type == 6)
								$type = "Skype";
							else if($data->type == 7)
								$type = "WhatsApp";
							else if($data->type == 8)
								$type = "Telegram";
							else if($data->type == 10)
								$type = "Google Plus";
							else if($data->type == 11)
								$type = "Twitter";
							else if($data->type == 12)
								$type = "Facebook";
							echo $type.": ".$data->contact."<br/>";
						}
					};?>
					
				</div>
			</div>
		<?php }?>

		<div class="clearfix publish">
			<?php echo $form->labelEx($model,'organization'); ?>
			<div class="desc">
				<?php 
				echo $form->radioButtonList($model,'organization', array(
					1 => 'Organization',
					0 => 'Personal',
				)); ?>
				<?php echo $form->error($model,'organization'); ?>
			</div>
		</div>
		
		<div id="organization" <?php echo $model->organization != 1 ? 'class="hide"' : ''; ?>>
			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('organization_name')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'organization_name',array('maxlength'=>64,'class'=>'span-6')); ?>
					<?php echo $form->error($model,'organization_name'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('organization_address')?> <span class="required">*</span></label>
				<div class="desc">
					<?php 
					//echo $form->textArea($model,'organization_address',array('rows'=>6, 'cols'=>50));
					$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
						'model'=>$model,
						'attribute'=>organization_address,
						// Redactor options
						'options'=>array(
							//'lang'=>'fi',
							'buttons'=>array(
								'html', '|', 
								'bold', 'italic', '|',
							),
						),
						'plugins' => array(
							'fullscreen' => array('js' => array('fullscreen.js')),
						),
					)); ?>
					<?php echo $form->error($model,'organization_address'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('organization_phone')?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'organization_phone',array('maxlength'=>15,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'organization_phone'); ?>
				</div>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'visitor'); ?>
			<div class="desc">
				<?php echo $form->textField($model,'visitor',array('maxlength'=>3,'class'=>'span-2')); ?>
				<?php echo $form->error($model,'visitor'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'start_date'); ?>
			<div class="desc">
				<?php
				!$model->isNewRecord ? ($model->start_date != '0000-00-00' ? $model->start_date = date('d-m-Y', strtotime($model->start_date)) : '') : '';
				//echo $form->textField($model,'start_date');
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$model,
					'attribute'=>'start_date',
					//'mode'=>'datetime',
					'options'=>array(
						'dateFormat' => 'dd-mm-yy',
					),
					'htmlOptions'=>array(
						'class' => 'span-3',
					 ),
				)); ?>
				<?php echo $form->error($model,'start_date'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'finish_date'); ?>
			<div class="desc">
				<?php
				!$model->isNewRecord ? ($model->finish_date != '0000-00-00' ? $model->finish_date = date('d-m-Y', strtotime($model->finish_date)) : '') : '';
				//echo $form->textField($model,'finish_date');
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$model,
					'attribute'=>'finish_date',
					//'mode'=>'datetime',
					'options'=>array(
						'dateFormat' => 'dd-mm-yy',
					),
					'htmlOptions'=>array(
						'class' => 'span-3',
					 ),
				)); ?>
				<?php echo $form->error($model,'finish_date'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'messages'); ?>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'messages',array('rows'=>6, 'cols'=>50));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>messages,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', 'formatting', '|', 
							'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'link', '|',
						),
					),
					'plugins' => array(
						'fontcolor' => array('js' => array('fontcolor.js')),
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
				)); ?>
				<?php echo $form->error($model,'messages'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		
		<?php
		if(!$model->isNewRecord) {
			$model->old_file = $model->message_file;
			echo $form->hiddenField($model,'old_file');
			if($model->message_file != '') {
				$file = Yii::app()->request->baseUrl.'/public/visit/'.$model->message_file;
				echo '<div class="clearfix">';
				echo $form->labelEx($model,'old_file');
				echo '<div class="desc"><a href="'.$file.'" title="'.$model->message_file.'">'.$model->message_file.'</a></div>';
				echo '</div>';
			}
		}?>

		<div class="clearfix">
			<?php echo $form->labelEx($model,'message_file'); ?>
			<div class="desc">
				<?php echo $form->fileField($model,'message_file'); ?>
				<?php echo $form->error($model,'message_file'); ?>
			</div>
		</div>
	<?php }?>

	<?php if(!$model->isNewRecord && $action == 'reply') {?>		
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('status')?> <span class="required">*</span></label>
			<div class="desc">
				<?php echo $form->dropDownList($model,'status', array(
					'0'=>'Pending',
					'1'=>'Approved (Add to Schedule)',
					'2'=>'Rejected',
				), array('prompt'=>'')); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($schedule,'start_date'); ?>
			<div class="desc">
				<?php
				$schedule->start_date = date('d-m-Y', strtotime($model->start_date));
				!$schedule->isNewRecord ? ($schedule->start_date != '0000-00-00' ? $schedule->start_date = date('d-m-Y', strtotime($schedule->start_date)) : '') : '';
				//echo $form->textField($schedule,'start_date');
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$schedule,
					'attribute'=>'start_date',
					//'mode'=>'datetime',
					'options'=>array(
						'dateFormat' => 'dd-mm-yy',
					),
					'htmlOptions'=>array(
						'class' => 'span-3',
					 ),
				)); ?>
				<?php echo $form->error($schedule,'start_date'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>

		<div class="clearfix">
			<?php echo $form->labelEx($schedule,'finish_date'); ?>
			<div class="desc">
				<?php
				$schedule->finish_date = date('d-m-Y', strtotime($model->finish_date));
				!$schedule->isNewRecord ? ($schedule->finish_date != '0000-00-00' ? $schedule->finish_date = date('d-m-Y', strtotime($schedule->finish_date)) : '') : '';
				//echo $form->textField($schedule,'finish_date');
				$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'model'=>$schedule,
					'attribute'=>'finish_date',
					//'mode'=>'datetime',
					'options'=>array(
						'dateFormat' => 'dd-mm-yy',
					),
					'htmlOptions'=>array(
						'class' => 'span-3',
					 ),
				)); ?>
				<?php echo $form->error($schedule,'finish_date'); ?>
				<?php /*<div class="small-px silent"></div>*/?>
			</div>
		</div>
		
		<div class="clearfix">
			<label><?php echo $model->getAttributeLabel('message_reply')?> <span class="required">*</span></label>
			<div class="desc">
				<?php 
				//echo $form->textArea($model,'message_reply',array('rows'=>6, 'cols'=>50));
				$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>message_reply,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', 'formatting', '|', 
							'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'link', '|',
						),
					),
					'plugins' => array(
						'fontcolor' => array('js' => array('fontcolor.js')),
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
				)); ?>
				<?php echo $form->error($model,'message_reply'); ?>
			</div>
		</div>
	<?php }?>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>


