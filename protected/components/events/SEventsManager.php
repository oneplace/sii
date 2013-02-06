<?php

class SEventsManager extends CApplicationComponent
{
	public $listeners;
	// protected $listenerInstances;
	
	public function init()
	{
		foreach ($this->listeners as $listener) {
			$listenerInstance = Yii::createComponent($listener);
			$listenerInstance->addListeners();
		}
	}
}
