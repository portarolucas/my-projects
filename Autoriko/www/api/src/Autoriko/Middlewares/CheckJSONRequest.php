<?php

namespace Autoriko\Middlewares;

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;
use Autoriko\Utils\Writer;

class CheckJSONRequest
{
  private $c;

  public function __construct($c){
    $this->c = $c;
  }

  public function check_json_header($req, $res) : bool{
    $contentType = $req->getContentType();
    if (strpos($contentType, 'application/json') !== false) {
      return true;
    }else{
      return false;
    }
  }

  public function valid_json_body($req) : bool{
    $json = $req->getBody();
    json_decode($json);
    return (json_last_error() == JSON_ERROR_NONE);
  }

  public function checkJSON($req, $res, $next) : Response{
    if($this->check_json_header($req, $res)){
      if($this->valid_json_body($req)){
        return $next($req, $res);
      }else{
        return Writer::json_error($response, $this->c['return_message']['bad_body_request_required_json']['code'], $this->c['return_message']['bad_body_request_required_json']['message']);
      }
    }else{
      return Writer::json_error($response, $this->c['return_message']['bad_header_request_required_json_content']['code'], $this->c['return_message']['bad_header_request_required_json_content']['message']);
    }
  }
}
