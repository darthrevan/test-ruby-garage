<?php

class TaskController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionCreate()  {
            var_dump($_REQUEST);
            $task = new Tasks;
            $task->attributes = $_POST["Tasks"];
           // var_dump($task);
            if($task->validate()) {
                $task->save();
            }
            else var_dump($task->getErrors());
        }
        public function actionChangeDoneStatus()    {
            var_dump($_REQUEST["post_id"]);
            $task = Tasks::model()->findByPk($_REQUEST["post_id"]);
            var_dump($task->done);
            if($task->done == true) $task->done = false;
            else $task->done = true;
            $task->update();
        }
        
        public function performAjaxValidation($model)   {
            if(isset($_REQUEST['Tasks']))        {
             return CActiveForm::validate($model);
            Yii::app()->end();
          }
        }
        
        public function actionUpdate()  {
            $task = Tasks::model()->findByPk($_REQUEST["Tasks"]['id']);
            $task->attributes = $_POST["Tasks"];
            $a = $task->validate();
            if(!$task->getErrors()) {
                $task->save();
            }
            else return CActiveForm::validate($task);
        }
        public function actionShowEditForm()  {
            $this->renderPartial("edit");
        }
        public function actionGetProject()  {
            $task = Tasks::model()->findByPk($_REQUEST['task_id']);
            //var_dump($task->project_id);
            if($task) echo $task->project_id;
        }
        
        public function actionDelete()  {
            $s = Tasks::model()->deleteByPk($_REQUEST["task_id"]);
        }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}