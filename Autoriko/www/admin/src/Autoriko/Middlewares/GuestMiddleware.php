<?php
namespace Autoriko\Middlewares;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Autoriko\Controllers\Auth\AuthController;

class GuestMiddleware {

    public function __construct(Container $container)
    {
        $this->container = $container;   
    }

    public function __invoke(Request $request, Response $response, $next) {
        //si t'es connecté tu es rigiré vers la page accueil
        if(AuthController::isLogged()) {
            return $response->withStatus(200)->withHeader('Location', $this->container->router->pathFor('home'));
        }

        //si t'es pas connecté ça continu et ça te demande de te connecter
        return $next($request, $response);
    }

}