<?php
namespace Gufy\CpanelWhm;

use Illuminate\Support\ServiceProvider;
use Gufy\CpanelPhp\Cpanel;

/**
 * Cpanel/WHM API Laravel Package
 *
 * Provides easy to use class for calling some CPanel/WHM API functions
 *
 * @author Mochamad Gufron <mgufronefendi@gmail.com>
 * @version v1.0.0
 * @link https://github.com/mgufrone/cpanel-whm
 * @since v1.0.0
 */
class CpanelWhm extends Cpanel
{
    use cPanelShortcuts;

    /**
     * @var string cPanel/WHM username
     */
    private $username;

    /**
     * @var string cPanel/WHM password.
     */
    private $password;

    /**
     * @var string cPanel/WHM host.
     */
    private $hostName;

    /**
     * @var string cPanel/WHM authentication type.
     */
    private $authType;

    public function __construct()
    {
        $this->username = config('cpanel-whm.username');
        $this->password = config('cpanel-whm.auth');
        $this->hostName = config('cpanel-whm.host');
        $this->authType = config('cpanel-whm.auth_type', 'hash');
    }

    /**
     * Create a new cPanel object
     *
     * @param $username
     * @param $password
     * @param null $hostname
     * @return static
     */
    public function get($username, $password, $hostname = null)
    {
        $cpanel = new static;

        if (empty($username)) {
            $cpanel->username = config('cpanel-whm.username');
        }

        if (empty($password)) {
            $cpanel->password = config('cpanel-whm.auth');
        }

        if (empty($hostname)) {
            $cpanel->hostName = config('cpanel-whm.host');
        }

        $cpanel->authType = config('cpanel-whm.auth_type', 'hash');

        return $cpanel;
    }

    /**
     * Set the cPanel hostname
     *
     * @param $hostname
     * @return $this
     */
    public function setHostname($hostname)
    {
        $this->hostName = $hostname;

        return $this;
    }

    /**
     * Set cPanel username and password.
     *
     * @param string $username
     * @param string $password password (usually auth token) from cPanel
     * @param null|string $hostname
     * @return $this
     */
    public function setAuthenticationDetails($username, $password, $hostname = null)
    {
        $this->username = $username;
        $this->password = $password;

        if (!empty($hostname)) {
            $this->hostName = $hostname;
        }

        return $this;
    }

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
        $this->setAuthorization($this->username, $this->password)
            ->setHost($this->hostName)
            ->setAuthType($this->authType);

        return parent::runQuery($action, $arguments);
    }

}