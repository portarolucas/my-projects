<?php

namespace Autoriko\Utils;

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

class Writer
{
  public static function json_output(Response $resp, int $code, array $data){
    $resp = $resp->withStatus($code);
    $json = json_encode($data);
    $resp->getBody()->write($json);
    return $resp;
  }

  public static function json_error(Response $resp, int $code, string $message, string $trace = null, string $file = null){
    $resp = $resp->withStatus($code);
    $data = [
      "type" => "error",
      "error" => $code,
      "message_status" => $message
    ];
    if($trace)
      $data["trace"] = $trace;
    if($file)
      $data["file"] = $file;
    $json = json_encode($data);
    $resp->getBody()->write($json);
    return $resp;
  }
}
