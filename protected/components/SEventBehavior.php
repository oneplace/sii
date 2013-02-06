<?php

class SEventBehavior extends CActiveRecordBehavior
{
	public function afterSave($event)
	{
		if($this->owner->isNewRecord) {
			$modelName = get_class($event->sender);
			Yii::app()->event->emit($modelName.'.created',array($event->sender,user(true)->publicInfo()));
		}
	}

	public function afterDelete($event)
	{
		
	}
}
