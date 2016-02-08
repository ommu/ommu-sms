<?php
/**
 * Book Reviews (book-reviews)
 * @var $this ReviewController * @var $model BookReviews * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'book-reviews-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset class="clearfix balance">
	<div class="clear">
		<div class="left">
			<div class="clearfix">
				<?php echo $form->labelEx($model,'book_input'); ?>
				<div class="desc">
					<?php 
					//echo $form->textField($model,'book_input',array('maxlength'=>64,'class'=>'span-8'));
					$url = Yii::app()->controller->createUrl('admin/ajaxget', array('type'=>'book'));
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $model,
						'attribute' => 'book_input',
						'source' => Yii::app()->controller->createUrl('admin/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$('form #BookMasters_title').val(ui.item.value);
								$('form #BookRequests_book_id').val(ui.item.id);
								$.ajax({
									type: 'post',
									url: '$url',
									data: { book_id: ui.item.id},
									dataType: 'json',
									success: function(response) {
										$('form #BookMasters_author_input').val(response.author_input);
										$('form #BookMasters_author_id').val(response.author_id);
										$('form #BookMasters_interpreter_input').val(response.interpreter_input);
										$('form #BookMasters_interpreter_id').val(response.interpreter_id);
										$('form #BookMasters_publisher_input').val(response.publisher_input);
										$('form #BookMasters_publisher_id').val(response.publisher_id);
										$('form #BookMasters_publish_city').val(response.publish_city);
										$('form #BookMasters_publish_year').val(response.publish_year);
									}
								});
							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-8',
							'maxlength'=>128,
						),
					));
					echo $form->error($model,'book_input');
					echo $form->hiddenField($model,'book_id');?>
				</div>
			</div>
			
			<div class="clearfix">
				<label><?php echo $book->getAttributeLabel('author_input');?> <span class="required">*</span></label>
				<div class="desc">
					<?php 
					//echo $form->textField($book,'author_input',array('maxlength'=>64,'class'=>'span-6'));
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $book,
						'attribute' => 'author_input',
						'source' => Yii::app()->controller->createUrl('masterauthor/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$('form #BookMasters_author_input').val(ui.item.value);
								$('form #BookMasters_author_id').val(ui.item.id);
							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-8',
						),
					));
					echo $form->error($book,'author_input');
					echo $form->hiddenField($book,'author_id'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($book,'interpreter_input'); ?>
				<div class="desc">
					<?php 
					//echo $form->textField($book,'interpreter_input',array('maxlength'=>64,'class'=>'span-6'));
					$url = Yii::app()->controller->createUrl('interpreter/ajaxadd', array('type'=>'book'));
					$books = $book->book_id;
					$interpreterId = '';
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $book,
						'attribute' => 'interpreter_input',
						'source' => Yii::app()->controller->createUrl('masterauthor/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$('form #BookMasters_interpreter_input').val(ui.item.value);
								$('form #BookMasters_interpreter_id').val(ui.item.id);
							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-8',
						),
					));
					echo $form->error($book,'interpreter_input');
					echo $form->hiddenField($book,'interpreter_id'); ?>
				</div>
			</div>

			<div class="clearfix">
				<label><?php echo $book->getAttributeLabel('publisher_input');?> <span class="required">*</span></label>
				<div class="desc">
					<?php
					//echo $form->textField($book,'publisher_input',array('maxlength'=>64,'class'=>'span-6')); 
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'model' => $book,
						'attribute' => 'publisher_input',
						'source' => Yii::app()->controller->createUrl('masterpublisher/suggest'),
						'options' => array(
							//'delay '=> 50,
							'minLength' => 1,
							'showAnim' => 'fold',
							'select' => "js:function(event, ui) {
								$('form #BookMasters_publisher_input').val(ui.item.value);
								$('form #BookMasters_publisher_id').val(ui.item.id);
							}"
						),
						'htmlOptions' => array(
							'class'	=> 'span-8',
						),
					));
					echo $form->error($book,'publisher_input');
					echo $form->hiddenField($book,'publisher_id'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($book,'publish_city'); ?>
				<div class="desc">
					<?php echo $form->textField($book,'publish_city',array('maxlength'=>32,'class'=>'span-6')); ?>
					<?php echo $form->error($book,'publish_city'); ?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($book,'publish_year'); ?>
				<div class="desc">
					<?php echo $form->textField($book,'publish_year',array('maxlength'=>4,'class'=>'span-4')); ?>
					<?php echo $form->error($book,'publish_year'); ?>
				</div>
			</div>
		</div>

		<div class="right">
			<div class="clearfix">
				<?php echo $form->labelEx($author,'name'); ?>
				<div class="desc">
					<?php echo $form->textField($author,'name',array('maxlength'=>32, 'class'=>'span-8')); ?>
					<?php echo $form->error($author,'name'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>

			<div class="clearfix">
				<?php echo $form->labelEx($author,'email'); ?>
				<div class="desc">
					<?php echo $form->textField($author,'email',array('maxlength'=>32, 'class'=>'span-8')); ?>
					<?php echo $form->error($author,'email'); ?>
					<?php /*<div class="small-px silent"></div>*/?>
				</div>
			</div>
	
			<div class="clearfix">
				<?php echo $form->labelEx($model,'published_date'); ?>
				<div class="desc">
					<?php 
					$model->isNewRecord ? '' : $model->published_date = date('d-m-Y', strtotime($model->published_date));
					//echo $form->textField($model,'published_date', array('class'=>'span-7'));
					$this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'model'=>$model, 
						'attribute'=>'published_date',
						//'mode'=>'datetime',
						'options'=>array(
							'dateFormat' => 'dd-mm-yy',
						),
						'htmlOptions'=>array(
							'class' => 'span-5',
						 ),
					));	?>
					<?php echo $form->error($model,'published_date'); ?>
				</div>
			</div>
			
			<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
			<div class="clearfix publish">
				<?php echo $form->labelEx($model,'comment_code'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'comment_code'); ?><?php echo $form->labelEx($model,'comment_code'); ?>
					<?php echo $form->error($model,'comment_code'); ?>
				</div>
			</div>
			<?php } else {
				$model->comment_code = 0;
				echo $form->hiddenField($model,'comment_code');
			}?>

			<?php if(OmmuSettings::getInfo('site_headline') == 1) {?>
			<div class="clearfix publish">
				<?php echo $form->labelEx($model,'headline'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'headline'); ?><?php echo $form->labelEx($model,'headline'); ?>
					<?php echo $form->error($model,'headline'); ?>
				</div>
			</div>
			<?php } else {
				$model->headline = 0;
				echo $form->hiddenField($model,'headline');
			}?>

			<div class="clearfix publish">
				<?php echo $form->labelEx($model,'publish'); ?>
				<div class="desc">
					<?php echo $form->checkBox($model,'publish'); ?><?php echo $form->labelEx($model,'publish'); ?>
					<?php echo $form->error($model,'publish'); ?>
				</div>
			</div>
		</div>
	</div>
</fieldset>

<fieldset>	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'quote'); ?>
		<div class="desc">
			<?php 
			//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
			$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
				'model'=>$model,
				'attribute'=>quote,
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
			<?php if($model->isNewRecord || (!$model->isNewRecord && $model->article_type != 4)) {?>
				<span class="small-px">Note : add {$quote} in description article</span>
			<?php }?>
			<?php echo $form->error($model,'quote'); ?>
		</div>
	</div>
	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'body'); ?>
		<div class="desc">
			<?php 
			//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50, 'class'=>'span-10 small'));
			$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
				'model'=>$model,
				'attribute'=>body,
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
			<?php echo $form->error($model,'body'); ?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Phrase::trans(1,0) : Phrase::trans(2,0) ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Phrase::trans(4,0), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


