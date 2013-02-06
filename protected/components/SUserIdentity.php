<?php

class SUserIdentity extends EAuthUserIdentity
{
	public $attributes = array();
	
	public function authenticate() {		
		if ($this->service->isAuthenticated) {
			$this->id = $this->service->id;
			$this->name = $this->service->getAttribute('name');
			
			$this->setState('id', $this->id);
			$this->setState('name', $this->name);
			$this->attributes['service'] = $this->service->serviceName;

			foreach ($this->service->getAttributes() as $key => $value) {
				if($key=='id' || $key=='name') continue;
				$this->attributes[$key] = $value;
			}
			$this->attributes['accessToken'] = $this->service->access_token;
			
			$this->errorCode = self::ERROR_NONE;		
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}

	public function setLocalId($id)
	{
		$this->id = $id;
		$this->setState('id', $id);
	}
}
