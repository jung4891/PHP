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

/*
  @ URI Routing : 사용자가 접근한 URI에 따라서 Controller의 메소드를 호출해주는 기능
                  (URI의 규칙은 배열을 이용한다.)
                 host/class/method/param
  http://ci/index.php/topic/get/2  -> application/controllers/topic.php의 get메소드 호출(인자 2 전달)

  @ URI 매핑 변경하기(URL remap) : URI에 따른 Controller의 호출 규칙을 변경하고자 할때
   1) http://ci/index.php/topic/get/2 -> http://ci/index.php/topic/2
      $route['topic/(:num)'] = 'topic/get/$1';
        - $1은 첫번째 괄호의 값으로 치환됨. back referencing이라고 함
        - :num은 들어가는 값이 숫자임을 의미
   2) http://ci/index.php/topic/get/2 -> http://ci/index.php/post/2  (주로 post로 들어오니까)
      $route['post/(:num)'] = 'topic/get/$1';
   3) http://ci/index.php/topic/get/2 -> http://ci/index.php/a22/ba/2
      $route['([a-z])/([a-z]+)/(\d+)'] = "topic/get/$3";
        - 정규표현식(문자에서 어떤 패턴을 찾아내는 일종의 프로그래밍 언어)도 사용할 수 있다.
        - [a-z] : 소문자만 하나 있어야함.
        - [a-z]+ : 소문자만 하나 이상 있으면 됨
        - \d+ : 숫자 하나 이상.
*/
// $route['topic/(:num)'] = 'topic/get/$1';    // 1)
// $route['post/(:num)'] = 'topic/get/$1';     // 2)
// $route['([a-z]\d+)/([a-z]+)/(\d+)'] = "topic/get/$3";   // 3)

$route['default_controller'] = 'topic/index'; // class/method
$route['404_override'] = 'topic/error';  // http://ci/index.php/abcd (존재하지 않는 페이지 접근시)
$route['translate_uri_dashes'] = FALSE;
