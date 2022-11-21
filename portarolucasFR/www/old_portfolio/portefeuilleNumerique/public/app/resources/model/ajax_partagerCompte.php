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
                echo "Impossible d'envoyer le message, aucun nom d'utilisateur n'a été trouvé, veuillez réessayer ou vous reconnecter";
            }
        }
        else
        {
            echo 'Vous devez être connecté pour envoyer un message.';
        }
    }
    else
    {
        echo 'Vous devez compléter tous les champs pour pouvoir envoyer un message.';
    }
}