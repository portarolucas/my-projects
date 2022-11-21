<?php

namespace Autoriko\Middlewares;

use Slim\Http\Response as Response;

class Cors{
  public function addCors($req, $res, $next) : Response{
    $response = $next($req, $res);

    if(isset($_SERVER) && isset($_SERVER['HTTP_ORIGIN']))
      $response = $response->withHeader('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
    else
      $response = $response->withHeader('Access-Control-Allow-Origin', '*');

    return $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, X-XSRF-TOKEN, withCredentials')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Expose-Headers', 'Set-Cookie');
  }
}
