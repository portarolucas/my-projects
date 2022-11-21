<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class PagesGetController extends Controller {

    public function accueil(Request $request, Response $response) {
        $route_name = $request->getAttribute('route')->getName();
        $this->render($response, 'Pages/Accueil.twig', ['route_name' => $route_name]);
    }

    public function blog(Request $request, Response $response) {
        $route_name = $request->getAttribute('route')->getName();
        $this->render($response, 'Pages/Blog.twig', ['route_name' => $route_name]);
    }

    public function contact(Request $request, Response $response) {
        $route_name = $request->getAttribute('route')->getName();
        $this->render($response, 'Pages/Contact.twig', ['route_name' => $route_name]);
    }

    public function filtreopure(Request $request, Response $response) {
        $route_name = $request->getAttribute('route')->getName();
        $this->render($response, 'Pages/BlogArticle/FiltreOpure.twig', ['route_name' => $route_name]);
    }

    /*public function logout(Request $request, Response $response) {
        return $this->redirect($response, 'login');
    }*/

}
