<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // data for menu
    public $menuItems = [];

    // constructor with data for menu
    public function __construct()
    {
      $this->menuItems = [
        [
            'title' => 'BVP',
            'url' => '/',
            'active' => false
        ],
        
        [
          'title'=> 'Login',
          'url'=> '/login',
          'active'=> false
        ] ,
          
      ];
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
