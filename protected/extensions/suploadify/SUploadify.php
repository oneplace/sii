<?php
class SUploadify extends CWidget
{
	const SCRIPTFILE = 'jquery.uploadify-3.1.min.js';
	const CSSFILE = 'uploadify.css';
	const SWFFILE = 'uploadify.swf';
	
	public $htmlOptions = array();
	public $uploader;
	public $options = array();
	protected $assetsUrl;
	
	public function init()
	{
		parent::init();
		$this->htmlOptions['id']=$this->getId();
		$this->publishAssets();
	}
	
	protected function publishAssets()
	{
		$assets = dirname(__FILE__) . '/assets';
		$this->assetsUrl = Yii::app()->assetManager->publish($assets);
		if (is_dir($assets)) {
			Yii::app()->clientScript->registerScriptFile($this->assetsUrl . '/' . SUploadify::SCRIPTFILE, CClientScript::POS_END);
			Yii::app()->clientScript->registerCssFile($this->assetsUrl . '/' . SUploadify::CSSFILE);
		} else {
			throw new CHttpException(500, 'SUploadify - Error: Couldn\'t find assets to publish.');
		}
	}
	
	protected function generateScript()
	{
		$id=$this->getId();
		$options = array(
			'uploader'=>$this->uploader,
			'swf'=>$this->assetsUrl . '/' . SUploadify::SWFFILE,
			//'onUploadSuccess'=>'js:function(file, data, response){console.log(data)}',
		);
		$options = array_merge($options,$this->options);
		$jsOptions=CJavaScript::encode($options);
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').uploadify({$jsOptions});", CClientScript::POS_READY);
	}
	
	public function run()
	{
		$this->generateScript();
		echo CHtml::fileField('file','',$this->htmlOptions);
	}
}