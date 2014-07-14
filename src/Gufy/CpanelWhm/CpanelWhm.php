<?php namespace Gufy\CpanelWhm;

use Illuminate\Support\ServiceProvider;

class CpanelWhm {

	public function __call($function, $arguments=[])
	{
		return $this->runQuery($function, $arguments);
	}

	public function runQuery($action, $arguments)
	{
		$headers = [];

		$username = \Config::get('cpanel-whm::username');
		$auth_type = \Config::get('cpanel-whm::auth_type');
		
		if('hash' == $auth_type)
			$headers['Authorization'] = 'WHM '.$username.':'. preg_replace("'(\r|\n)'","",\Config::get('cpanel-whm::auth'));
		elseif('password' == $auth_type)
			$headers['Authorization'] = 'Basic '.$username.':'. preg_replace("'(\r|\n)'","",\Config::get('cpanel-whm::auth'));

		$host = \Config::get('cpanel-whm::host');
		$response = \GuzzleHttp\post($host.'/json-api/'.$action, [
		    'headers' => $headers,
		    'body'    => $arguments,
		    'verify'  => false,

		]);
		return $response->json();
	}
}
