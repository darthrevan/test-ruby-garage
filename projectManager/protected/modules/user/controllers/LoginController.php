<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
                        $rendered = 0;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
                                
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
                                        $this->renderPartial("application.views.project.index",array("model"=> new Projects),false,true);
                                        $rendered = 1;
				}
                                else{
                                    
                                }
			}
			// display the login form
                        
			if(!$rendered) $this->renderPartial('/user/login',array('model'=>$model));
		} else
			$this->renderPartial('/user/login',array('model'=>$model));
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}