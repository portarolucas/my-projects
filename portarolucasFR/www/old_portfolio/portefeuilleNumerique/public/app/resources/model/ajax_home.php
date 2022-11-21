<?php

session_start();

function databaseCon()
{
    $db = new PDO('mysql:host=fortnitelulucasp.mysql.db;dbname=fortnitelulucasp', 'fortnitelulucasp', 'Portefeuille123');
    $db->exec("set names utf8");
    return $db;
}

function giveDateUS()
{
    $d = date('d');
    $m = date('m');
    $y = date('Y');
    return ($m.'/'.$d.'/'.$y);
}

if(isset($_GET['findSearchUser']))
{
    if(isset($_GET['chaine']) && $_GET['chaine'] != '')
    {
        $chaine = $_GET['chaine'];
        $db = databaseCon();
        $req = $db->prepare("
				SELECT username
				FROM user
				WHERE username LIKE '".$chaine."%'
				AND username 
				NOT LIKE '".$_SESSION['username']."' 
				;
			");
        $req->execute();
        if($req->rowCount())
        {
            $rep = $req->fetchAll();
            $list;
            for ($i=0; $i < count($rep); $i++)
            {
                $list[$i] = $rep[$i][0];
            }
            echo json_encode($list);
        }
    }
    else
    {
        echo 'erreur';
    }
}
elseif(isset($_GET['delCompte']))
{
    if(isset($_POST['compteID']) && isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if(isset($_SESSION['username']) && $_SESSION['username'] != '')
            {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $db = databaseCon();
                $req = $db->prepare("
						SELECT `delete_compte`(:idUser, :idCompte);
					");
                $req->execute(array(
                    'idUser' => $idUser,
                    'idCompte' => $idCompte
                ));
                if($req->rowCount())
                {
                    $rep = $req->fetch();
                    echo $rep[0];
                }
                else
                {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            else
            {
                echo "Impossible de supprimer le compte, veuillez réessayer ou vous reconnecter";
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
}
elseif(isset($_GET['updatePass']))
{
    if(isset($_POST['compteID']) && isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if(isset($_POST['newPass']) && $_POST['newPass'] != '')
            {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $newPass = $_POST['newPass'];
                $db = databaseCon();
                $req = $db->prepare("
						SELECT `updatePass_compte`(:idUser, :idCompte, :unMdp);
					");
                $req->execute(array(
                    'idUser' => $idUser,
                    'idCompte' => $idCompte,
                    'unMdp' => $newPass
                ));
                if($req->rowCount())
                {
                    $rep = $req->fetch();
                    echo $rep[0];
                }
                else
                {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            else
            {
                echo "Impossible de mettre à jour le mot de passe par un mot de passe vide ou inexistant.";
            }
        }
        else
        {
            echo 'Vous devez être connecté pour mettre à jour le mot de passe.';
        }
    }
    else
    {
        echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
    }
}
elseif(isset($_GET['updateCompte']))
{
    if(isset($_POST['compteID']) && isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if(isset($_POST['newMail']) && isset($_POST['newLogin']) && isset($_POST['newPass']) && isset($_POST['newService']) && isset($_POST['newCategorie']))
            {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $db = databaseCon();
                $req = $db->prepare("
						SELECT `update_compte`(:idUser, :idCompte, :unMail, :unLogin, :unMdp, :unService, :uneCategorie);
					");
                $req->execute(array(
                    'idUser' => $idUser,
                    'idCompte' => $idCompte,
                    'unMail' => $_POST['newMail'],
                    'unLogin' => $_POST['newLogin'],
                    'unMdp' => $_POST['newPass'],
                    'unService' => $_POST['newService'],
                    'uneCategorie' => $_POST['newCategorie']
                ));
                if($req->rowCount())
                {
                    $rep = $req->fetch();
                    echo $rep[0];
                }
                else
                {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            else
            {
                echo "Impossible de mettre à jour le compte car des champs sont manquants.";
            }
        }
        else
        {
            echo 'Vous devez être connecté pour mettre à jour le mot de passe.';
        }
    }
    else
    {
        echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
    }
}
elseif(isset($_GET['addCompte']))
{
    if(isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if(isset($_POST['newMail']) && isset($_POST['newLogin']) && isset($_POST['newPass']) && isset($_POST['newService']) && isset($_POST['newCategorie']))
            {
                $idUser = $_SESSION["userID"];
                $db = databaseCon();
                $req = $db->prepare("
						INSERT INTO `compte`(`login`, `mdp`, `mail`, `date`, `creator_id`, `id_service`, `id_categorie`) VALUES (:unLogin,:unMdp,:unMail, CURDATE(), :creator_id,:unService,:uneCategorie);
					");
                $req->execute(array(
                    'unLogin' => $_POST['newLogin'],
                    'unMdp' => $_POST['newPass'],
                    'unMail' => $_POST['newMail'],
                    'creator_id' => $_SESSION["userID"],
                    'unService' => $_POST['newService'],
                    'uneCategorie' => $_POST['newCategorie']
                ));
                if($req->rowCount())
                {
                    $rep = $req->fetch();
                    echo $rep[0];
                }
                else
                {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            else
            {
                echo "Impossible de créer le compte car des champs sont manquants.";
            }
        }
        else
        {
            echo 'Vous devez être connecté pour ajouter un compte.';
        }
    }
    else
    {
        echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
    }
}
elseif(isset($_GET['addService']))
{
    if(isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if(isset($_POST['newUrl']) && isset($_POST['newPort']) && isset($_POST['newNom']))
            {
                $idUser = $_SESSION["userID"];
                $db = databaseCon();
                $req = $db->prepare("
						INSERT INTO `service`(`urlService`, `portService`, `nom`, `id_user`) VALUES (:newUrl,:newPort,:newNom,:creator_id);
					");
                $req->execute(array(
                    'newUrl' => $_POST['newUrl'],
                    'newPort' => $_POST['newPort'],
                    'newNom' => $_POST['newNom'],
                    'creator_id' => $_SESSION["userID"]
                ));
                if($req->rowCount())
                {
                    $rep = $req->fetch();
                    echo $rep[0];
                }
                else
                {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            else
            {
                echo "Impossible de créer le service car des champs sont manquants.";
            }
        }
        else
        {
            echo 'Vous devez être connecté pour ajouter un service.';
        }
    }
    else
    {
        echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
    }
}
elseif(isset($_GET['updateUser']))
{
    if(isset($_SESSION["userID"]))
    {
        if(isset($_SESSION['connected']) && $_SESSION['connected'])
        {
            if (isset($_POST['_usernameAccountU']) && $_POST['_usernameAccountU'] != '' && $_POST['_usernameAccountU'] != null) {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $db = databaseCon();
                $req = $db->prepare("
						UPDATE `user` SET `username` = :username WHERE id = :idUser;
					");
                $req->execute(array(
                    'idUser' => $idUser,
                    'username' => $_POST['_usernameAccountU']
                ));
                if ($req->rowCount()) {
                    $rep = $req->fetch();
                } else {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            } else {
                echo "Impossible de mettre à jour le compte car des champs sont manquants.";
            }

            if (isset($_POST['_mailAccountU']) && $_POST['_mailAccountU'] != '' && $_POST['_mailAccountU'] != null) {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $db = databaseCon();
                $req = $db->prepare("
                            UPDATE `user` SET `email` = :email WHERE id = :idUser;
                        ");
                $req->execute(array(
                    'idUser' => $idUser,
                    'email' => $_POST['_mailAccountU']
                ));
                if ($req->rowCount()) {
                    $rep = $req->fetch();
                } else {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
            if (isset($_POST['_passwordAccountU']) && $_POST['_passwordAccountU'] != '' && $_POST['_passwordAccountU'] != null) {
                $idUser = $_SESSION["userID"];
                $idCompte = $_POST['compteID'];
                $db = databaseCon();
                $req = $db->prepare("
                            UPDATE `user` SET `mdp` = :mdp WHERE id = :idUser;
                        ");
                $req->execute(array(
                    'idUser' => $idUser,
                    'mdp' => $_POST['_passwordAccountU']
                ));
                if ($req->rowCount()) {
                    $rep = $req->fetch();
                } else {
                    echo "Une erreur est survenue dans la requête SQL.";
                }
            }
        }
        else
        {
            echo 'Vous devez être connecté pour mettre à jour ls informations de votre compte utilisateur.';
        }
    }
    else
    {
        echo 'Une erreur est survenue, veuillez réessayer ou vous reconnecter.';
    }
}