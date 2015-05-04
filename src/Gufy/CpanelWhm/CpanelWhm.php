<?php
/**
 * Cpanel/WHM API Laravel Package
 *
*/
namespace Gufy\CpanelWhm;

use Illuminate\Support\ServiceProvider;
use Gufy\CpanelPhp\Cpanel;

/**
 * Provides easy to use class for calling some CPanel/WHM API functions
 *
 * @author Mochamad Gufron <mgufronefendi@gmail.com>
 * @version v1.0.0
 * @link https://github.com/mgufrone/cpanel-whm
 * @since v1.0.0
*/
class CpanelWhm  extends Cpanel
{
	/**
	* This method override its parent method 'runQuery()'
	*
	* @see parent::runQuery
  * @param string $action function name that will be called.
  * @param string $arguments list of parameters that will be attached.
  * @return array results of API call
	* @since v1.0.0
	*/
	protected function runQuery($action, $arguments)
	{
		$this->setAuthorization(
			config('cpanel-whm.username'),
			config('cpanel-whm.auth')
		)
		->setHost(config('cpanel-whm.host'))
		->setAuthType(config('cpanel-whm.auth_type', 'hash'));

		return parent::runQuery($action, $arguments);
	}
}
