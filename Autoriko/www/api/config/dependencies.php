<?php

return [
    'dbhost' => function(\Slim\Container $c) {
        $config = parse_ini_file($c->settings['dbfile']);
        return $config['host'];
    },

    'logger' => function(\Slim\Container $c){
        $log = new \Monolog\Logger($c->settings['debug.name']);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->settings['debug.log'],$c->settings['debug.level']));
        return $log;
    },
    'logger.error' => function(\Slim\Container $c){
        $log = new \Monolog\Logger($c->settings['error.name']);
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->settings['error.log'], $c->settings['error.level']));
        return $log;
    }
];
