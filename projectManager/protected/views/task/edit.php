<script>
$(function() {
		$("#datepicker" ).datepicker();
	});
</script>
<?php 
$id = $_GET['task_id'];
$model = Tasks::model()->findByPk($id);

        
        
        $form = $this->beginWidget('CActiveForm', array(
        'id'=>'task-form',
       // 'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'focus'=>array($model,'name'),
        'action'=>$this->createUrl('project/create')
     ));
        ?>
            
            
<div class="row">
    <?php echo $form->labelEx($model,'name',array("class"=>"taskLabel")); ?><br>
    <?php echo $form->textField($model,'name'); ?><br>
    <?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'status',array("class"=>"taskLabel")); ?><br>
    <?php echo $form->textField($model,'status'); ?><br>
    <?php echo $form->error($model,'status'); ?>
   
    <?php echo $form->hiddenField($model,'id'); ?>
  
</div>



<div class="row">
    <?php echo $form->labelEx($model,'deadline',array("class"=>"taskLabel")); ?><br>
    <?php echo $form->textField($model,'deadline',array('id'=>"datepicker")); ?><br>
    <?php echo $form->error($model,'deadline'); ?>
</div>



    <?php
        
        
        $this->endWidget(); 
        
    ?>