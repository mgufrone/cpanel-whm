<?php namespace Gufy\CpanelWhm;

use Illuminate\Support\ServiceProvider;
use Gufy\CpanelPhp\Cpanel;

class CpanelWhm  extends Cpanel{

	public function runQuery($action, $arguments)
	{
		$this->setAuthorization(
			\Config::get('cpanel-whm::username'),
			\Config::get('cpanel-whm::auth')
		)
		->setHost(\Config::get('cpanel-whm::host'))
		->setAuthType(\Config::get('cpanel-whm::auth_type', 'hash'));

		return parent::runQuery($action, $arguments);
	}
}
