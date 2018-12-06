<?php namespace ProcessWire;

$classPath = __DIR__ . '/classes/';
$apiClasses = array_diff(scandir($classPath), array('.', '..'));
$endpoints =  wire('pages')->get('/api-endpoints/')->children;

require_once wire('config')->paths->RestApi . "vendor/autoload.php";
require_once wire('config')->paths->RestApi . "RestApiHelper.php";

foreach($apiClasses as $apiClass){
  require_once $classPath . $apiClass;
}

$routes = [
  ['OPTIONS', 'test', RestApiHelper::class, 'preflight', ['auth' => false]], // this is needed for CORS Requests
  ['GET', 'test', Example::class, 'test'],
  
  'users' => [
    ['OPTIONS', '', RestApiHelper::class, 'preflight', ['auth' => false]], // this is needed for CORS Requests
    ['GET', '', Example::class, 'getAllUsers', ["auth" => false]],
    ['GET', '{id:\d+}', Example::class, 'getUser', ["auth" => false]], // check: https://github.com/nikic/FastRoute
  ],
];

foreach($endpoints as $endpoint){
  $endpointOptions = false;
  $endpointOptions[] = ['OPTIONS', '', RestApiHelper::class, 'preflight', ['auth' => false]];
  foreach($endpoint->children as $method){
    $endpointOptions[] = [
      $method->title,
      $method->api_fastrouteoption,
      __NAMESPACE__ . '\\' . $method->api_class,
      $method->api_class_method,
      ['auth' =>  $method->api_auth],
    ];
    $routes[$endpoint->title] = $endpointOptions;
  }
}