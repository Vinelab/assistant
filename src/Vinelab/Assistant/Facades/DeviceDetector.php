<?php

namespace Vinelab\Assistant\Facades;

use Illuminate\Support\Facades\Facade;

class DeviceDetector extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vinelab.assistant.devicedetector';
    }
}
