<?php

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

return [
    'notFoundHandler'=>function(\Slim\Container $c){
        return function(Request $rq, Response $rs) use($c): Response {

            $uri = $rq->getUri();

            $rs = $rs->WithStatus(400)
                     ->withHeader('Content-Type', 'application/json');

            $rs->write(json_encode(
                [
                    'type'      => 'error',
                    'error'     => 400,
                    "message"   => "$uri : url incorrect"
                ]
            ));

            return $rs;
        };
    },
    'notAllowedHandler'=>function(\Slim\Container $c){
        return function(Request $rq, Response $rs, array $methods) use($c): Response {
            $method = $rq->getMethod();
            $uri = $rq->getUri();

            $rs = $rs->WithStatus(405)
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('Allow', implode(', ', $methods))
                    ->write( json_encode(['type'=>'error',
                    'error'=>405,
                    "message"=>"method $method not allowed for uri $uri - (should be ".
                    implode(', ',$methods).')']));
            return $rs;
        };
    },
    'phpErrorHandler'=>function(\Slim\Container $c){
        return function(Request $rq, Response $rs, \Throwable $error) use($c): Response {
            $c['logger.error']->error("Error : " . $error->getMessage()
            . "- File : " . $error->getFile()
            . "- Line : " . $error->getLine()
            . "- Trace : " . $error->getTraceAsString() . "\n\r");
            $rs = $rs->WithStatus(500)
                    ->withHeader('Content-Type', 'application/json')
                    ->write( json_encode(['type'=>'error',
                    'error'=>500,
                    "message"=>"internal server error",
                    ]));
            return $rs;
        };
    }
];
