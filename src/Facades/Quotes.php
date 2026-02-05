<?php
namespace MyVendor\Quotes\Facades;

use Illuminate\Support\Facades\Facade;

class Quotes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MyVendor\\Quotes\\Services\\QuoteService';
    }
}
