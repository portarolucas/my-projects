<?php

use Twig\Extra\Intl\IntlExtension;

$container = $app->getContainer();

$container['view'] = function($container) {
    $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir . '/Autoriko/Views', [
        // 'cache' => $dir . '/tmp/cache'
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    $view->addExtension(new IntlExtension());

    $view->getEnvironment()->addGlobal('auth', $_SESSION);

    return $view;
};