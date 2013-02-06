<?php
/**
 * SinaOAuthService class file.
 *
 * Register application: http://open.weibo.com
 * 
 * @author Chuck911 <contact@with.cat>
 * @link http://github.com/Chuck911/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

/**
 * Facebook provider class.
 * @package application.extensions.eauth.services
 */
class SinaOAuthService extends EOAuth2Service {	
	
	protected $name = 'sina';
	protected $title = 'Sina';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 290));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://api.weibo.com/oauth2/authorize',
		'access_token' => 'https://api.weibo.com/oauth2/access_token',
	);
	protected $uid;
		
	protected function fetchAttributes() {
		$options = array('query'=>array('uid'=>$this->uid));
		$info = (object) $this->makeSignedRequest('https://api.weibo.com/2/users/show.json',$options);

		$this->attributes['id'] = $info->id;
		$this->attributes['name'] = $info->name;
		// $this->attributes['url'] = $info->link;
		$this->attributes['avatar'] = $info->profile_image_url;
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
		$response = $this->makeRequest($this->providerOptions['access_token'], array('query' => $params,'data'=>array()));
		return $response;
	}
		
	/**
	 * Save access token to the session.
	 * @param array $token access token array.
	 */
	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token->access_token);
		$this->access_token = $token->access_token;
		$this->uid = $token->uid;
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
