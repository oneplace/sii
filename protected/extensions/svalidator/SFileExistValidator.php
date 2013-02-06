<?php

class SFileExistValidator extends CValidator
{
	public $path = null;
	public $allowEmpty = true;

	protected function validateAttribute($object,$attribute)
	{
		$value = $object->$attribute;
		if($this->allowEmpty && $this->isEmpty($value)) return;
		if(strpos($value,'http://')===0) return;
		$file = $this->path.$value;
		if(!file_exists($file)){
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} "{file}" is not a existing file.',array('{file}'=>$file));
			$this->addError($object,$attribute,$message);
		}
	}
}
