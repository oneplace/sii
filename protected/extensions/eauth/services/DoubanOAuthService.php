<?php
/**
 * DoubanOAuthService class file.
 *
 * Register application: http://developers.douban.com/apikey/apply
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
class DoubanOAuthService extends EOAuth2Service {	
	
	protected $name = 'douban';
	protected $title = 'Douban';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 290));
	protected $scope = 'douban_basic_common,shuo_basic_r';

	protected $providerOptions = array(
		'authorize' => 'https://www.douban.com/service/auth2/auth',
		'access_token' => 'https://www.douban.com/service/auth2/token',
	);

	protected function getAccessToken($code) {
		$params = array(
			'grant_type'=>'authorization_code',
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'code' => $code,
			'redirect_uri' => 'http://kibey.com/system/site/connect',
		);
		$response = $this->makeRequest($this->providerOptions['access_token'], array('data' => $params));
		return $response;
	}

	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token->access_token);
		$this->access_token = $token->access_token;
	}

	protected function getCodeUrl($redirect_uri) {
		return $this->providerOptions['authorize'].'?client_id='.$this->client_id.'&redirect_uri='.urlencode($redirect_uri).'&scope='.$this->scope.'&response_type=code&need_permission=true';
	}

	protected function fetchAttributes() {
		$info = (object) $this->makeSignedRequest('https://api.douban.com/v2/user/~me');
		$this->attributes['id'] = $info->id;
		$this->attributes['name'] = $info->name;
		$this->attributes['avatar'] = $info->avatar;
	}

	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated())
			throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the request because the user was not authenticated.'));
	
		$options['headers'] = array('Authorization: Bearer ' . $this->access_token);
		$result = $this->makeRequest($url, $options, $parseJson);
		return $result;
	}

}