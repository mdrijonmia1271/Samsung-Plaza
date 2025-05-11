<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = "access/users/login";
$route['admin']              = "access/users/login";
$route['user']               = "access/subscriber/login";
$route['client/logout']      = "client/login/logout";
$route['404_override']       = '';
