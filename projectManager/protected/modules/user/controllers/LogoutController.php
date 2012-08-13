<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
            
		Yii::app()->user->logout();
                echo "Thank you for using the tool!";
                echo "<br>";
                echo CHtml::link("Come back and Login again","index.php");
               // echo "ilogout";
		//$this->redirect(Yii::app()->controller->module->returnLogoutUrl);

	}

}