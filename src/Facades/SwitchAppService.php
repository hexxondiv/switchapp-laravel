<?php

namespace Hexxondiv\SwitchappLaravel\Facades;
use Illuminate\Support\Facades\Facade;

class SwitchAppService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'switchApp';
    }
}
