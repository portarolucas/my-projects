<?php

namespace Autoriko\Middlewares;

use Slim\Http\Response as Response;
use Autoriko\Utils\Writer;

class GlobalHeaders
{
  public function addAndCheckJsonHeaders($req, $res, $next) : Response{
    $accept = $req->getHeaderLine('Accept');
    if(!$accept || (strpos($accept, 'application/json') !== false)){
      $response = $next($req, $res);
      return $response
              ->withHeader('Content-Type', 'application/json');
    }else{
      return Writer::json_error($res, 406, "{$accept} in 'Accept' header is not valid. Only 'application/json' is allowed.");
    }
  }
}
