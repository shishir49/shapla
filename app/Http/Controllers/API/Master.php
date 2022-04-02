<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Master extends Controller
{
    public function Welcome(){

        $software_name = 'Shapla';
    	$welcome_msg = 'Welcome To '.$software_name.' !';
    	$software_type = 'Inventory Management System';
    	$version = 'v1.0';

    	$data = array(
           'welcome_msg'     => $welcome_msg,
           'software_type'   => $software_type,
           'version'         => $version
    	);
    	return json_encode($data);
    }
}
