<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IgnoreThisController extends Controller
{

    /**
     * @codeCoverageIgnore
     * @return NULL
     */
    public function my()
    {
        return null;
    }
    
    public function ok() 
    {
        return self::my();
    }
}
