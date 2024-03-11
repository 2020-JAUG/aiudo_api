<?php

namespace App\Helpers;

class ExceptionHelper
{
    public static function formatExceptionMessage($exception): string
    {
        return $exception->getMessage() . ' on line ' . $exception->getLine() . ' in file ' . $exception->getFile();
    }
}
