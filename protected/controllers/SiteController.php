<?php
class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	
	public function actionRegister()
	{
		$model = new RegisterForm;
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes = $_POST['RegisterForm'];
			if($model->validate())
			{
				$user = new User;
				$user->name = $model->name;
				$user->email = $model->email;
				$user->password = $model->password;
				if($user->save()){
					Yii::app()->user->setFlash('success', 'You are successfully registered.');
					$this->sendMail($this->renderPartial('verify_email',array('user'=>$user),true),$user->email);
				}
				$model = new RegisterForm;
			}
		}
		$this->render('register',array('model'=>$model));
	}
	
	public function sendMail($body,$to){
		$message = new YiiMailMessage;
		$message->setBody($body, 'text/html');
		$message->subject = 'Activate your AppRunes Developer account';
		$message->addTo($to);
		$message->from = Yii::app()->params['adminEmail'];
		Yii::app()->mail->send($message);
	}
	
	public function actionVerify($id,$code)
	{
		$user = User::model()->findByPk($id);
		if($user && $user->status==0 && $user->verifyKey == $code)
		{
			$user->status=1;
			$user->save();
			Yii::app()->user->setFlash('success', 'You are successfully activated.');
		}else{
			Yii::app()->user->setFlash('warning', 'Invalid Verify URL');
		}
		$this->redirect(array('site/login'));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}