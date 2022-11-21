<?php
	
namespace classes;
	
class DAOPortefeuille
{
	private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->connection->exec("set names utf8");
    }

	public function find_serviceID($id_service)
	{
		$stmt = $this->connection->prepare
			('SELECT * FROM Service Where id_service = :id_service');
		$stmt->setFetchMode(\PDO::FETCH_CLASS, 'Service');
		return $stmt->fetch();
	}
		
		
		
	public function getLesServices()
	{
		$stmt = $this->connection->prepare
			('SELECT * FROM service');
		$stmt->execute();
		//$stmt->setFetchMode(\PDO::FETCH_CLASS, 'User');
			
		return $stmt->fetchAll();
	}

    public function getLesCategories()
    {
        $stmt = $this->connection->prepare
        ('SELECT * FROM categorie');
        $stmt->execute();
        //$stmt->setFetchMode(\PDO::FETCH_CLASS, 'User');

        return $stmt->fetchAll();
    }
		
		
	public function addService($Service)
	{
		if(!isset($Service->id_service))
		{
			throw new \LogicException
			(
				'Problème survenu'
			);
		}
			
		$stmt = $this->connection->prepare
			(
			'INSERT INTO Service(nom,date,url,port)
			VALUES(:nom, :date, :url; :port)'
			);
			
		$stmt->bindParam(':nom', $Service->nom);
		$stmt->bindParam(':date', $Service->date);
		$stmt->bindParam(':url', $Service->url);
		$stmt->bindParam(':port', $Service->port);
			
		return $stmt->execute();
	}
		
	public function deleteServiceID($Service)
	{
		if(!isset($Service->id_service))
		{
			throw new \logicException
			(
				'Effacement impossible du service.'
			);
		}
				
		$stmt = $this->connection->prepare
			('DELETE FROM Service
			WHERE id_service =: id_service');
				
		$stmt->bindParam(':id_service', $Service->id_service);
		return $stmt->execute();
	}
		
		
		
		
		//intégrer un compte utilisateur
		//login+ mot de passe
	public function find_compteID($id_compte)
	{
		$stmt = $this->connection->prepare
			('SELECT * FROM Compte Where id_compte = :id_compte');
		$stmt->setFetchMode(\PDO::FETCH_CLASS, 'Compte');
		return $stmt->fetch();
	}
		
	public function addCompte($Compte)
	{
		if(!isset($Compte->id_compte))
		{
			throw new \LogicException
			(
				'Problème survenu'
			);
		}

		$stmt = $this->connection->prepare
			('INSERT INTO Compte(date,nom,login,motDePasse,dateChangementMdp,id_service)
			VALUES(:date, :nom, :url; :port, :id_service)');

        $stmt->bindParam(':date', $Compte->date);
		$stmt->bindParam(':nom', $Compte->nom);
		$stmt->bindParam(':login', $Compte->login);
		$stmt->bindParam(':motDePasse', $Compte->motDePasse);
		$stmt->bindParam(':dateChangementMdp',$Compte->dateChangementMdp);
		$stmt->bindParam(':id_service', $Compte->$getLeService()->id_service);
			
		return $stmt->execute();
	}

	public function updateService($Compte)
	{
		if(!isset($Compte->id_compte))
		{
			throw new \LogicException
			(
				'Problèmes de mise à jour de la base.'
			);
		}
			
		$stmt = $this->connection->prepare
			('UPDATE Compte 
			SET nom = :nom;
				date = :date;
				login = :login;
				motDePasse =:motDePasse;
				dateChangementMdp =:dateChangementMdp;
				id_service =: id_service
			WHERE id_compte = :id_compte');

		$stmt->bindParam(':nom', $compte->nom);
		$stmt->bindParam(':date', $compte->date);
		$stmt->bindParam(':login', $compte->login);
		$stmt->bindParam(':motDePasse', $compte->motDePasse);
		$stmt->bindParam(':dateChangementMdp', $compte->dateChangementMdp);
		$stmt->bindParam(':id_service', $compte->getLeService());
		
			
		return $stmt->execute();
	}
	
	public function deleteCompteID($Compte)
	{
		if(!isset($Compte->id_compte))
		{
			throw new \logicException
			(
				'Effacement impossible du compte.'
			);
		}
				
		$stmt = $this->connection->prepare
			('DELETE FROM Compte
			WHERE id_service =: id_compte');
				
		$stmt->bindParam(':id_compte', $Compte->id_compte);
		return $stmt->execute();
	}
			
	public function seConnecter($email,$motDePasse)
	{
		$stmt = $this->connection->prepare
			('SELECT id, username, isAdmin FROM user Where email = :email AND mdp = :motDePasse');
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':motDePasse', $motDePasse);
        $stmt->execute();
		return $stmt->fetch();
	}

    public function seInscrire($tabData)
    {
        $stmt = $this->connection->prepare
        ('SELECT create_user(:username, :email, :mdp, :confirmmdp);');
        $stmt->bindParam(':username', $tabData['username']);
        $stmt->bindParam(':email', $tabData['mail']);
        $stmt->bindParam(':mdp', $tabData['mdp']);
        $stmt->bindParam(':confirmmdp', $tabData['confirmmdp']);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

	public function partagerUnCompte($unCompte, $userIDCible)
    {
        $stmt = $this->connection->prepare
        ('INSERT INTO `partager_compte`(`id_user`, `id_compte`) VALUES (:userID,:compteID)');
        $stmt->bindParam(':userID', $userIDCible);
        $stmt->bindParam(':compteID', $unCompte->getId());
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLesComptesByID($unID)
    {
        $stmt = $this->connection->prepare
        ('SELECT compte.id, compte.login, compte.mdp, compte.dateChangementMdp, compte.mail, compte.date, service.idService, service.urlService, service.portService, service.nom AS nomService, service.date AS dateService, compte.id_categorie, categorie.nomCategorie
FROM compte INNER JOIN service ON compte.id_service = service.idService INNER JOIN categorie ON compte.id_categorie = categorie.id WHERE service.id_user = :id ORDER BY compte.id');
        $stmt->bindParam(':id', $unID);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Compte');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLesStatistiques()
    {
    	$stmt = $this->connection->prepare
        ('SELECT id_categorie, categorie.nomCategorie, COUNT(id_categorie) AS nb_compte
		FROM compte
		INNER JOIN categorie ON categorie.id = compte.id_categorie
		GROUP BY id_categorie');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>