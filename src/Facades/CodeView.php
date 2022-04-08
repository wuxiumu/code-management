<?php
namespace Wqb\CodeView\Facades;
use Illuminate\Support\Facades\Facade;
class CodeView extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'codeview';
    }
}