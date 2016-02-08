<?php
/**
 * Book Masters (book-masters)
 * @var $this AdminController * @var $model BookMasters * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'book-masters-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php 
	echo $form->errorSummary($model);
	if(Yii::app()->user->hasFlash('error'))
		echo Utility::flashError(Yii::app()->user->getFlash('error'));
	if(Yii::app()->user->hasFlash('success'))
		echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
	?>
</div>
<?php //begin.Messages ?>


<fieldset class="clearfix">
	<div class="clear">
		<div class="left">

			<div class="clearfix">
				<?php echo $form->labelEx($model,'isbn'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'isbn',array('maxlength'=>64,'class'=>'span-6')); ?>
					<?php echo $form->error($model,'isbn'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('title');?> <span class="required">*</span></label>
				<div class="desc">
					<?php echo $form->textField($model,'title',array('maxlength'=>128,'class'=>'span-8')); ?>
					<?php echo $form->error($model,'title'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'description'); ?>
				<div class="desc">
					<?php 
					//echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50));
					$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
						'model'=>$model,
						'attribute'=>description,
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
							'table' => array('js' => array('table.js')),
							'fullscreen' => array('js' => array('fullscreen.js')),
						),
					)); ?>
					<?php echo $form->error($model,'description'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
			
			<?php if(!$model->isNewRecord) {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'author_input'); ?>
				<div class="desc">
					<?php 
					//echo $form->textField($model,'author_input',array('maxlength'=>64,'class'=>'span-6'));
					$url = Yii::app()->controller->createUrl('author/ajaxadd', array('type'=>'book'));
					$book = $model->book_id;
					$authorId = 'BookMasters_author_input';
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $model,
						'attribute' => 'author_input',
						'source' => Yii::app()->controller->createUrl('masterauthor/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$.ajax({
									type: 'post',
									url: '$url',
									data: { book_id: '$book', author_id: ui.item.id, author: ui.item.value },
									dataType: 'json',
									success: function(response) {
										$('form #$authorId').val('');
										$('form #book-author').append(response.data);
									}
								});

							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-6',
						),
					));
					echo $form->error($model,'author_input'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
					<div id="book-author" class="suggest clearfix">
						<?php if($author != null) {
							foreach($author as $key => $val) {?>
							<div><?php echo $val->author_relation->author_name;?><a href="<?php echo Yii::app()->controller->createUrl('author/delete',array('id'=>$val->id,'type'=>'book'));?>" title="<?php echo Phrase::trans(173,0);?>"><?php echo Phrase::trans(173,0);?></a></div>
						<?php }
						}?>
					</div>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'interpreter_input'); ?>
				<div class="desc">
					<?php 
					//echo $form->textField($model,'interpreter_input',array('maxlength'=>64,'class'=>'span-6'));
					$url = Yii::app()->controller->createUrl('interpreter/ajaxadd', array('type'=>'book'));
					$book = $model->book_id;
					$interpreterId = 'BookMasters_interpreter_input';
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $model,
						'attribute' => 'interpreter_input',
						'source' => Yii::app()->controller->createUrl('masterauthor/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$.ajax({
									type: 'post',
									url: '$url',
									data: { book_id: '$book', interpreter_id: ui.item.id, interpreter: ui.item.value },
									dataType: 'json',
									success: function(response) {
										$('form #$interpreterId').val('');
										$('form #book-interpreter').append(response.data);
									}
								});

							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-6',
						),
					));
					echo $form->error($model,'interpreter_input'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
					<div id="book-interpreter" class="suggest clearfix">
						<?php if($interpreter != null) {
							foreach($interpreter as $key => $val) {?>
							<div><?php echo $val->interpreter_relation->author_name;?><a href="<?php echo Yii::app()->controller->createUrl('interpreter/delete',array('id'=>$val->id,'type'=>'book'));?>" title="<?php echo Phrase::trans(173,0);?>"><?php echo Phrase::trans(173,0);?></a></div>
						<?php }
						}?>
					</div>
				</div>
			</div>
			<?php }?>

			<div class="clearfix">
				<label><?php echo $model->getAttributeLabel('publisher_input');?> <span class="required">*</span></label>
				<div class="desc">
					<?php
					echo $form->hiddenField($model,'publisher_id');
					$model->publisher_input = $model->publisher->publisher_name;
					//echo $form->textField($model,'publisher_input',array('maxlength'=>64,'class'=>'span-6')); 
					$url = Yii::app()->controller->createUrl('masterpublisher/ajaxadd', array('type'=>'book'));
					$publisherId = 'BookMasters_publisher_input';
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $model,
						'attribute' => 'publisher_input',
						'source' => Yii::app()->controller->createUrl('masterpublisher/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								if(ui.item.id != 0) {
									$('form #$publisherId').val(ui.item.value);
									$('form #BookMasters_publisher_id').val(ui.item.id);
								} else {
									$.ajax({
										type: 'post',
										url: '$url',
										data: { publisher: ui.item.value },
										dataType: 'json',
										success: function(response) {
											$('form #$publisherId').val(ui.item.value);
											$('form #BookMasters_publisher_id').val(response.publisher_id);
										}
									});
									
								}

							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-6',
						),
					));
					if(!$model->isNewRecord) {
						$model->old_publisher_input = $model->publisher_input;
						echo $form->hiddenField($model,'old_publisher_input');
						$model->old_publisher_id = $model->publisher_id;
						echo $form->hiddenField($model,'old_publisher_id');	
					}
					echo $form->error($model,'publisher_input'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'publish_city'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'publish_city',array('maxlength'=>32,'class'=>'span-6')); ?>
					<?php echo $form->error($model,'publish_city'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'publish_year'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'publish_year',array('maxlength'=>4,'class'=>'span-4')); ?>
					<?php echo $form->error($model,'publish_year'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
			
			<?php if(!$model->isNewRecord) {?>
			<div class="clearfix">
				<?php echo $form->labelEx($model,'subject_input'); ?>
				<div class="desc">
					<?php 
					//echo $form->textField($model,'subject_input',array('maxlength'=>64,'class'=>'span-6'));
					$url = Yii::app()->controller->createUrl('subject/ajaxadd', array('type'=>'book'));
					$book = $model->book_id;
					$subjectId = 'BookMasters_subject_input';
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $model,
						'attribute' => 'subject_input',
						'source' => Yii::app()->controller->createUrl('mastersubject/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$.ajax({
									type: 'post',
									url: '$url',
									data: { book_id: '$book', subject_id: ui.item.id, subject: ui.item.value },
									dataType: 'json',
									success: function(response) {
										$('form #$subjectId').val('');
										$('form #book-subject').append(response.data);
									}
								});

							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-6',
						),
					));
					echo $form->error($model,'subject_input'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
					<div id="book-subject" class="suggest clearfix">
						<?php if($subject != null) {
							foreach($subject as $key => $val) {?>
							<div><?php echo $val->subject_relation->subject;?><a href="<?php echo Yii::app()->controller->createUrl('subject/delete',array('id'=>$val->id,'type'=>'book'));?>" title="<?php echo Phrase::trans(173,0);?>"><?php echo Phrase::trans(173,0);?></a></div>
						<?php }
						}?>
					</div>
				</div>
			</div>
			<?php }?>
		</div>

		<div class="right">
			<?php if(!$model->isNewRecord) {
				$model->old_cover = $model->cover;
				echo $form->hiddenField($model,'old_cover');
				if($model->cover != '') {
					$cover = Yii::app()->request->baseUrl.'/public/book/book/'.$model->cover;?>			
					<div class="clearfix">
						<?php echo $form->labelEx($model,'old_cover'); ?>
						<div class="desc">
							<img src="<?php echo Utility::getTimThumb($cover, 320, 500, 3);?>" alt="<?php echo $model->title;?>">
							<?php echo $form->error($model,'old_cover'); ?>
						</div>
					</div>					
			<?php }				
			}?>
			
			<div class="clearfix">
				<?php echo $form->labelEx($model,'cover'); ?>
				<div class="desc">
					<?php echo $form->fileField($model,'cover',array('maxlength'=>64)); ?>
					<?php echo $form->error($model,'cover'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'edition'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'edition',array('maxlength'=>32,'class'=>'span-9')); ?>
					<?php echo $form->error($model,'edition'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'paging'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'paging',array('maxlength'=>64,'class'=>'span-9')); ?>
					<?php echo $form->error($model,'paging'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($model,'sizes'); ?>
				<div class="desc">
					<?php echo $form->textField($model,'sizes',array('maxlength'=>64,'class'=>'span-9')); ?>
					<?php echo $form->error($model,'sizes'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix publish">
				<?php echo $form->labelEx($model,'publish'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'publish'); ?>
					<?php echo $form->labelEx($model,'publish'); ?>
					<?php echo $form->error($model,'publish'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget(); ?>


