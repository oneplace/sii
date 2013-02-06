<?php
class ConversationModule extends CWebModule
{
	public $defaultController = 'message';

	public function init()
	{
		$this->setImport(array(
			'conversation.models.*',
		));	
	}
	
}
