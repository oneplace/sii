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
class QQOAuthService extends EOAuth2Service 
{	
	protected $name = 'qq';
	protected $title = 'QQ';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 290));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://graph.qq.com/oauth2.0/authorize',
		'access_token' => 'https://graph.qq.com/oauth2.0/token',
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

	
	protected function fetchAttributes() {
		$result = $this->makeSignedRequest('https://graph.qq.com/oauth2.0/me',array(),false);
		
		preg_match('/callback\(\s+(.*?)\s+\)/i', $result,$match);
		$info = json_decode($match[1]);
//var_dump($info);Yii::app()->end();
		$userInfo = $this->getUserInfo($info->openid);
		$this->attributes['id'] = $info->openid;
		$this->attributes['name'] = $userInfo->nickname;
		$this->attributes['avatar'] = $userInfo->figureurl;
		$this->attributes['gender'] = $userInfo->gender;
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
		parse_str($response, $result);
		return $result;
	}
			
	/**
	 * Save access token to the session.
	 * @param array $token access token array.
	 */
	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token['access_token']);
		$this->setState('expires', isset($token['expires']) ? time() + (int)$token['expires'] - 60 : 0);
		$this->access_token = $token['access_token'];
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
