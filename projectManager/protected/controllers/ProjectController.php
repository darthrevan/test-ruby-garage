<?php

class ProjectController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionCreate() {
            if(Yii::app()->request->isAjaxRequest)  {
                //var_dump($_REQUEST['Projects']);
                $model = new Projects;
                //    var_dump($_POST);
                $model->user_id = Yii::app()->user->id;
                $e = $this->performAjaxValidation($model);
                $e = CJSON::decode($e);
                if (!$e)   {
                    
                    $model->attributes = $_POST["Projects"];
                    $model->save();
                    echo CJSON::encode($model->attributes);
                    //var_dump($model->attributes);
                    
                    
                }
                else {
                   
                   var_dump($e);
                   foreach($e as $id=>$errors)    {
                       foreach($errors as $error)    {
                           echo $error."<br>";
                       }
                   }
                }
                
                
                //
            }
            
        }
        
        
        public function actionDisplayList() {
        }
        
        public function performAjaxValidation($model)   {
            if(isset($_REQUEST['Projects']))        {
             return CActiveForm::validate($model);
            Yii::app()->end();
          }
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