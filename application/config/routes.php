<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';

$route['users/(:num)/(:any)'] = "users/home/$1/$2";//个人主页
$route['users/(:num)'] = "users/home/$1";//个人主页
$route['ucenter/admin'] = "ucenter_admin";//个人中心管理主页
$route['ucenter/admin/(:any)'] ="ucenter_admin/$1";//个人中心管理
$route['profile/(:num)/(:any)'] = "users/profile/$1/$2";//个人资料
$route['fans/(:num)/(:any)'] = "users/fans/$1/$2";//粉丝
$route['follow/(:num)/(:any)'] = "users/follow/$1/$2";//关注

/* End of file routes.php */
/* Location: ./application/config/routes.php */