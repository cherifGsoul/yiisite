<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'topic-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'), // ADD THIS
)); ?>

<?php
  $this->widget('CMultiFileUpload', array(
     'name'=>'media',
     'accept'=>'jpg|gif',
      'denied'=>'wrong file type',
  ));?>
<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
</div>

<?php $this->endWidget(); ?>