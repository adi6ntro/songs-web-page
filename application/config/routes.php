<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['search/(:any)'] = 'home/search/$1';
$route['songs/(:num)'] = 'songs/detail/$1';
$route['selected'] = 'songs/selected';
$route['savenote'] = 'songs/savenote';
$route['selected/record'] = 'songs/selected_save';
$route['login'] = 'auth';
$route['verify'] = 'auth/verify';
$route['activate/(:any)'] = 'auth/activate/$1';
$route['logout'] = 'auth/logout';
$route['myaccount'] = 'auth/myaccount';
$route['sign_up'] = 'auth/signup/cek';
$route['signup'] = 'auth/signup';
$route['signup/createnote'] = 'auth/signup/createnote';
$route['forgot'] = 'auth/forgot';
$route['register'] = 'auth/register';
$route['change/username'] = 'auth/change_username';
$route['change/password'] = 'auth/change_password';
$route['delete-account'] = 'auth/delete_account';
$route['loadmore'] = 'home/loadmore';
$route['autocomplete/language'] = 'home/get_autocomplete/language';
$route['autocomplete/song'] = 'home/get_autocomplete/song';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['frequent_questions'] = 'home/frequent_questions';
$route['contact_us'] = 'home/contact_us';
$route['coming_soon'] = 'home/coming_soon';