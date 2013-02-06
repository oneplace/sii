<?php
/**
 * QQOAuthService class file.
 *
 * @author Chuck911 <contact@with.cat>
 * @link http://github.com/chuck911/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

/**
 * Facebook provider class.
 * @package application.extensions.eauth.services
 */
class RenrenOAuthService extends EOAuth2Service 
{	
	protected $name = 'renren';
	protected $title = 'Renren';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 290));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://graph.renren.com/oauth/authorize',
		'access_token' => 'https://graph.renren.com/oauth/token',
	);
	
	public function getUserInfo($openid) {
		$params = array(
			"oauth_consumer_key" => $this->client_id,
			"openid"             => $openid,
			"format"             => "json"	
		);
		$info = $this->makeSignedRequest('https://graph.qq.com/user/get_user_info',array('query'=>$params));
		return $info;
	}

	protected function getCodeUrl($redirect_uri) {
		$this->setState('redirect_uri', $redirect_uri);
		return parent::getCodeUrl($redirect_uri);
	}
	
	protected function getAccessToken($code) {
		$params = array(
			'grant_type'=>'authorization_code',
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'code' => $code,
			'redirect_uri' => $this->getState('redirect_uri'),
		);
        
		$response = $this->makeRequest($this->getTokenUrl($code), array('query' => $params), false);
		$result = json_decode($response,true);
		return $result;
	}
			
	/**
	 * Save access token to the session.
	 * @param array $token access token array.
	 */
	protected function saveAccessToken($token) {
		//$this->setState('auth_token', $token['access_token']);
		//$this->setState('expires', isset($token['expires']) ? time() + (int)$token['expires'] - 60 : 0);
		$this->access_token = $token['access_token'];
		$this->fetched = true;
		$this->attributes['id'] = $token['user']['id'];
		$this->attributes['name'] = $token['user']['name'];
		$this->attributes['avatar'] = $token['user']['avatar'][1]['url'];
		// var_dump($this->attributes);Yii::app()->end();
	}
	
	/**
	 * Returns the error info from json.
	 * @param stdClass $json the json response.
	 * @return array the error array with 2 keys: code and message. Should be null if no errors.
	 */
	protected function fetchJsonError($json) {
		if (isset($json->error)) {
			return array(
				'code' => $json->error->code,
				'message' => $json->error->message,
			);
		}
		else
			return null;
	}		
}
