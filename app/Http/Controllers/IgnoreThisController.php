<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Log::info('123');
        return self::my();
    }
}
