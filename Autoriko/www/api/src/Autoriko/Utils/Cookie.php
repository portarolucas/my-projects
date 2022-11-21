<?php

namespace Autoriko\Utils;

use Slim\Http\Response as Response;
use Slim\Http\Request as Request;

class Cookie
{
    public static function deleteCookie($cookieName)
    {
        $arr_cookie_options = array (
                        'expires' => time() - 3600,
                        'secure' => false,//TODO utiliser le https pour la release donc changer cette ligne est passé 'secure' à true
                        'httponly' => true
        );
        setcookie($cookieName, "", $arr_cookie_options);
    }

    public static function addCookie($cookieName, $cookieValue, $expirationHour)
    {
        $expirationUnite = 3600; // 3600 = 1 heure || 60 = 1 minute

        $arr_cookie_options = array (
                        'path' => '/',
                        'secure' => false,//TODO utiliser le https pour la release donc changer cette ligne est passé 'secure' à true
                        'httponly' => true,
                        'expires' => time() + ($expirationHour * $expirationUnite),
                        'SameSite' => 'Strict'//None
        );

        setcookie($cookieName, $cookieValue, $arr_cookie_options);
        //$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        //$domain = 'http://localhost:8080';
        //setcookie('cookiename', 'data', time()+60*60*24*3600, '/', $domain, false);
    }

    public static function getCookieValue(Request $request, $cookieName)
    {
        $cookies = $request->getCookieParams();
        return isset($cookies[$cookieName]) ? $cookies[$cookieName] : null;
    }

}
