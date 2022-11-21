<?php

error_reporting(E_ALL);
session_start();

function databaseCon()
{
    $db = new PDO('mysql:host=fortnitelulucasp.mysql.db;dbname=fortnitelulucasp', 'fortnitelulucasp', 'Portefeuille123');
    $db->exec("set names utf8");
    return $db;
}

if(isset($_SESSION["userID"]))
{
    if(isset($_SESSION['connected']) && $_SESSION['connected'])
    {
        $idUser = $_SESSION["userID"];
        $db = databaseCon();
        $req = $db->prepare("
					SELECT `username`, `email` FROM user WHERE `id` = :idUser;
				");
        $req->execute(array(
                'idUser' => $idUser
        ));
        if($req->rowCount())
        {
            $rep = $req->fetch();
        }
        else
            {
            echo "Une erreur est survenue dans la requête SQL.";
        }
    }
    else
    {
        echo 'Vous devez être connecté pour supprimer un compte.';
    }
}
else
{
    echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
}

?>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateUserInfoLabel">Gestion de votre compte utilisateur</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="control-label" for="_usernameAccountU">Nom d'utilisateur :</label>
                        <input type="text" id="_usernameAccountU" class="form-control usernameCompteU" value="<?=$rep[0]?>">
                        <label class="control-label" for="_mailAccountU">Adresse mail :</label>
                        <input type="text" id="_mailAccountU" class="form-control mailCompteU" value="<?=$rep[1]?>">
                        <label class="control-label" for="_passwordAccountU">Nouveau mot de passe :</label>
                        <input type="text" id="_passwordAccountU" class="form-control passwordAccountU">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-dark" onclick="updateUserInfo()">Mettre à jour</button>
            </div>
        </div>
    </div>
