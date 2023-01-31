<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Older777\CurrEx\CurrExClass;

class CurrExController extends Controller
{
    public function page()
    {
        $currex = CurrExClass::instance();
        echo <<<TXT
            1 USD = {$currex::getExRate('EUR', false, false)} EUR<br />
            1 USD = {$currex::getExRate('CNY')} CNY<br />
            1 USD = {$currex::getExRate('JPY')} JPY<br />
            1 USD = {$currex::getExRate('RUB')} RUB<br />
            1 USD = {$currex::getExRate('GBP')} GBP<br />
            1 USD = {$currex::getExRate('BRL')} BRL<br />
        TXT;
    }
}
