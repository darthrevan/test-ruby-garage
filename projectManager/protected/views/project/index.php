<div class="logoutLink">
<?
echo CHtml::ajaxLink("Logout",
                           $this->createUrl("/user/logout"),
                           array("update"=>"#content"),
        array("id"=>uniqid()."logout"
                ));
?>
</div>
<?php

//
// the link that may open the dialog

    $projects = Projects::model()->findAllByAttributes(array("user_id"=>Yii::app()->user->id),array("order"=>"id DESC"));
    foreach($projects as $project)  {
    
        $dataProvider = new CActiveDataProvider("Tasks",array(
        "criteria"=>array(
            "condition"=>"project_id = ".$project->id
            )
        ));
        echo "<div class=\"projectName\">".$project->name."</div>";
        $task = new Tasks;
        $form = $this->beginWidget('CActiveForm', array(
            'id'=>'task-form'.$project->id,
          'enableClientValidation'=>true,
           'focus'=>array($task,'name'),
           'action'=>Yii::app()->createUrl("task/create")
        ));
        echo "<div class=\"addTaskBlock\">";
        echo $form->textField($task,"name");    //,array("id"=>"projectName".$project->id
        echo $form->hiddenField($task,"project_id",array("value"=>$project->id));
        echo CHtml::ajaxSubmitButton("Add Task",
                   Yii::app()->createUrl("task/create"),
                   array("success"=>"updateGrid({$project->id})"),
                    array("id"=>uniqid(),
                           "class"=>"addTaskBtn"));
        echo "</div>";
        $this->endWidget();
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'id'=>'grid'.$project->id,
            'hideHeader'=>true,
            'columns'=>array(
               array("value"=>'CHtml::checkbox("pew",
                         $data->done,
                         array("onclick"=>"setDone($data->id);"))',
                         'type'=>"raw",
                         'visible'=>true,
                         'htmlOptions'=>array("width"=>"30px;")
                   ),
                     
                'name',
                array("value"=>'CHtml::link("<img src=\"images/editIcon.png\">",
                         "",
                         array("onclick"=>"editTask($data->id);",
                            "style"=>"cursor:pointer;"))',
                         'type'=>"raw",
                         'visible'=>true,
                         'htmlOptions'=>array("width"=>"30px;")
                   ),
                array("value"=>'CHtml::link("<img src=\"images/deleteIcon.gif\">",
                         "",
                         array("onclick"=>"deleteTask($data->id);",
                            "style"=>"cursor:pointer;"))',
                         'type'=>"raw",
                         'visible'=>true,
                         'htmlOptions'=>array("width"=>"30px;")
                   ),
            )
            
        ));
        
    }
    
   ?><!--<div id="newProject">new placeholder old</div>-->
   <div class="addTodoBlock">
    <?php
    echo CHtml::link("Add TODO List","",array("onclick"=>'$("#modalAdd").dialog("open");','class'=>'addTodoLink'));
    
    ?>
   </div>
    <?php 
    
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'modalAdd',
    'options'=>array(
        'title'=>'New Project',
        'width'=>400,
        'height'=>200,
        'autoOpen'=>false,
        'resizable'=>false,
        'modal'=>true,
        'overlay'=>array(
            'backgroundColor'=>'#000',
            'opacity'=>'0.5'
        ),
        'buttons'=>array(
            'OK'=>'js:function(){
                $.post(
                    $("#project-form").attr("action"),
                    $("#project-form").serialize(),
                    function () {
                        $(this).dialog("close");
                        location.reload();
                    }
                );
            }',
            'Cancel'=>'js:function(){$(this).dialog("close");}',    
        ),
    ),
));
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'project-form',
       // 'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'focus'=>array($model,'name'),
        'action'=>$this->createUrl('project/create')
     ));
        
    ?>

<div id="error"></div>

<div class="row">
    <?php echo $form->labelEx($model,'name'); ?>
    <?php echo $form->textField($model,'name',array("class"=>"projectNameField")); ?>
    <?php echo $form->error($model,'name'); ?>
</div>

<?php 
    $this->endWidget(); 
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    
    //echo $form->errorSummary($model); 
?>
<div id="secret" style="display:none"></div>
<div id="dialog-modal" style="display:none;"> 
    
    
</div>
<script>
    function updateGrid(id)    {
       $.fn.yiiGridView.update("grid"+id);
    }
    function setDone(id)  {
       var url = '<?php echo Yii::app()->createUrl("task/changeDoneStatus");?>';
       $.post(url, {post_id: id});
       $.fn.yiiGridView.update("grid"+id);
    }
    function editTask(taskId) {
       $(function() {
                $.get('<?php echo Yii::app()->createUrl("task/showEditForm");?>',
                   {'task_id':taskId},
                   function(data){
                       $("#dialog-modal").html(data);
                       $("#dialog-modal").dialog({
			modal: true,
                        width:400,
                        resizable: false,
                        title: 'Edit task',
                        buttons:   {
                            "Ok": function() { 
                                $.post(
                                    "<?php echo Yii::app()->createUrl("task/update");?>",
                                    $("#task-form").serialize(),
                                    function(data) { 
                                        if(!data)   {
                                           $("#dialog-modal").dialog('close'); 
                                           $.get(
                                                '<?php echo Yii::app()->createUrl("task/getProject"); ?>',
                                                {'task_id':taskId},
                                                function(data)  {
                                                    console.log(data);
                                                    updateGrid(data);
                                                }
                                           );
                                           
                                    }
                                }
                                    
                                );
                            },
                            "Cancel": function() { $("#dialog-modal").dialog('close'); }
                        }
		});
                   });
		
	});
       //$.post();
    }
    
    
    function deleteTask(taskId)   {
        $("#dialog-modal").html("Are you sure?");
        $("#dialog-modal").dialog({
			modal: true,
                        resizable: false,
                        title: 'Delete confirmation',
                        buttons:   {
                            "Yes": function()   {
                                        var pid = 0;
                                        $.get(
                                            '<?php echo Yii::app()->createUrl("task/getProject"); ?>',
                                            {'task_id':taskId},
                                            function(data)  {
                                                
                                                $.post(
                                                    '<?php echo Yii::app()->createUrl("task/delete"); ?>',
                                                    {'task_id':taskId},
                                                    function(data)  {
                                                        $("#dialog-modal").dialog('close'); 
                                                    
                                                    }
                                                );
                                                updateGrid(data);
                                            }
                                        );
                                           // console.log($("#secret").html());
                                            //console.log(pid);
                                           
                                        
                                    },
                            "No": function()    {}
                            
                        }
    });
    }
</script>

