<?php

class Notice extends CWidget
{
	public $model;
	public $data;

	public $acceptLabel = '接受';
	public $rejectLabel = '拒绝';
	public $acceptLink;
	public $rejectLink;
	
	public function init()
	{
		$this->data = json_decode($this->model->data,true);
	}

	public function run()
	{
		$this->render($this->model->type,$this->data);
		if($this->model->mode=='request')
			$this->render('links',$this->data);
	}

	public function acceptLink()
	{
		return $this->parseLink($this->acceptLink);
	}

	public function parseLink($link)
	{
		if(!is_array($link) || !count($link)) return false;
		$url = array_shift($link);
		$params = array();
		if(count($link)){
			foreach ($link as $key => $value) {
				$attributes = explode('.',$value);
				$val = $this->data;
				foreach ($attributes as $attribute) {
					$val = $val[$attribute];
				}
				$params[$key] = $val;
			}
		}
		return Yii::app()->createUrl($url,$params);
	}

	public function rejectLink($route=null,$params=array())
	{
		return $this->parseLink($this->rejectLink);
	}
}
