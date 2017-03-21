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

    /**
     * Class constructor.
     */
    public function __construct($server_key = false)
    {
        if(!$this->setConfig($server_key)){
            $error = $server_key ? 'Error, the specified server could not be found' : 'Error, no servers have been stored';
            abort(500, $error);
        }
    }

    /**
     * Helper function to select server
     *
     * @param $server_key
     * @return CpanelWhm
     */
    public static function server($server_key)
    {
        return new self($server_key);
    }

    /**
     * Set the config settings
     *
     * @param $server_key
     * @return bool
     */
    public function setConfig($server_key)
    {
        $server = $this->fetchConfig($server_key);
        if(!$server) return false;
        $this->username = $server['username'];
        $this->password = $server['auth'];
        $this->hostName = $server['host'];
        $this->authType = !empty($server['auth_type']) ? $server['auth_type'] : 'hash';
        //$this->authType = $server['auth_type'] ?? 'hash'; // PHP 7+
        return true;
    }

    /**
     * Fetch the config settings with fallbacks
     *
     * @param $server_key
     * @return bool|mixed
     */
    public function fetchConfig($server_key)
    {
        $servers = config('cpanel-whm.servers');
        if($server_key) {
            // If has server key : Get that one
            if(empty($servers[$server_key])) return false; // Validate
            $server = $servers[$server_key];
        } elseif(!empty($servers)) {
            // No server key? cool get the first one
            $server = reset($servers);
        } else {
            // Legacy config settings
            $server = config('cpanel-whm');
        }
        return $server;
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
     * Fetch the current hostname
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostName;
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

        $host = $hostname;
        if (empty($hostname)) {
            $host = config('cpanel-whm.host');
        }

        $cpanel->setAuthenticationDetails($username, $password, $host);

        return $cpanel;
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
