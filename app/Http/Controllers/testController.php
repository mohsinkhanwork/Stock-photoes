<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect,Response;

use App\User;

class testController extends Controller
{
    public function test() {
        $array = [
            1,
            2,
            3,
            4,
            5
        ];
        unset($array[3]);
        $array = array_values($array);
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}
