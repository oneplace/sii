<?php
function getOr404($modelClass,$id){
	$model=$modelClass::model()->findByPk($id);
	if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
	return $model;
}

function user($model=false){
	if(!$model) return Yii::app()->getUser();
	else return User::current();
}

function getParam($name,$defaultValue=null){
	return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $defaultValue);
}
