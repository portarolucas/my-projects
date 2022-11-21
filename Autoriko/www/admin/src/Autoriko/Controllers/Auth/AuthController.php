<?php
namespace Autoriko\Controllers\Auth;

use Autoriko\Controllers\Controller;
use Autoriko\Models\Administrateur;

class AuthController extends Controller {

    public static function login($mail, $password) {
        $status = false;
        $user = Administrateur::where('mail', $mail)->first();
        if(!is_null($user)) {
            if(self::verifyPassword($password, $user->mdp)) {
                $_SESSION['id_admin'] = $user->id_admin;
                $_SESSION['mail'] = $user->mail;
                $status = true;
            }
        }
        return $status;
    }

    public static function logout() {
        unset($_SESSION['id_admin']);
        unset($_SESSION['mail']);
    }

    public static function isLogged() {
        if(isset($_SESSION['id_admin'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function verifyPassword($password, $db_password) {
        return password_verify($password, $db_password);
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}