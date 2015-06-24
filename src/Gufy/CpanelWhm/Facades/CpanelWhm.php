<?php namespace Gufy\CpanelWhm\Facades;

use Illuminate\Support\Facades\Facade;

class CpanelWhm extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpanel-whm';
    }

}