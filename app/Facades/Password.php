<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static generate()
 */
class Password extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'helpers.password';
    }

}
