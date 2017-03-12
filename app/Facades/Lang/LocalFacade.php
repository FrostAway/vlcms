<?php

namespace App\Facades\Lang;

use Illuminate\Support\Facades\Facade;

class LocalFacade extends Facade{
    public static function getFacadeAccessor() {
        return 'languages';
    }
}

