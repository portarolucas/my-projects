<?php
class Compte extends Acces 
{
    protected $id;
	protected $login;
	protected $mdp;
	protected $dateChangementMdp;
	protected $urlService;
	protected $portService;
	protected $nomService;
	protected $dateService;
	protected $id_categorie;
	protected $nomCategorie;
	
	// le service associé si il existe
	protected $idService;


	/*public function __construct($login, $mdp, $dateChangementMDP)
    {
        $this->login = $login;
        $this->motDePasse = $mdp;
        $this->dateChangementMDP = $dateChangementMDP;
    }*/

    public function __construct()
    {

    }

	/*
	* Renverra sous la forme d'une chaîne la concaténation des attributs de la classe
	* Exemple : 
	* Compte Mail professionnel - 01/12/2018 - eric.dondelinger@ac-nancy-metz.fr - 1234 - 15/10/2018
	*/
    public function afficher()
    {
		return 'Compte '.$this->nom.' - '.$this->date.' - '.$this->login.' - '.$this->motDePasse.' - '.$this->dateChangementMDP;
	}

	/**
	* GETTERS ET SETTERS
	*/
    public function getId() {
        return $this->id;
    }
    public function getLogin() {
        return $this->login;
	}
	public function getMdp() {
        return $this->mdp;
	}
	public function getDateChangementMDP() {
        return $this->dateChangementMDP;
	}
	public function getUrlService() {
        return $this->urlService;
    }
    public function getPortService() {
        return $this->portService;
    }
    public function getNomService() {
        return $this->nomService;
    }
    public function getDateService() {
        return $this->dateService;
    }
	public function getIdService(){
		return $this->idService;
	}
	public function getIdCategorie(){
		return $this->id_categorie;
	}
	public function getNomCategorie(){
		return $this->nomCategorie;
	}
	
	public function setLogin($l) {
        $this->login = $l;
	}
	public function setMotDePasse($m) {
        $this->motDePasse = $m;
	}
	public function setDateChangementMDP($d) {
        $this->dateChangementMDP = $d;
	}
	public function setLeService($s) {
        $this->leService = $s;
	}
	
	/*
	* Vérification de la robustesse du MDP
	*/
	public function testerMotDePasse()
	{
		if(strlen($this->motDePasse) <= 8) 
		{
	    	return 0;//mot de passe trop court
		}
		else if(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $this->motDePasse))
		{
			return 3;//mot de passe fort [composé de lettre (min et maj), numéro  et caractère spécial]
		}
		else if((preg_match('#^(?=.*[a-z])(?=.*[0-9])#', $this->motDePasse) || (preg_match('#^(?=.*[A-Z])(?=.*[0-9])#', $this->motDePasse))))
		{
			return 2;//mot de passe correct [composé de lettre et numéro]
		}
		else if(preg_match('#^(?=.*\W)#', $this->motDePasse))
		{
			return 2;//mot de passe correct [composé de caractère spéciaux]
		}
		else
		{
			return 1;//mot de passe trop faible
		}
	}
	/*
	* Vérification si le MDP a été changé depuis moins de 3 mois
	*/
	public function verifierObsolescence()
	{
		$dateChange = new DateTime($this->dateChangementMDP);
		$dateChange = $dateChange->format('Y-m-d');
		$dateChange = new DateTime($dateChange);
		$today = new DateTime();
		$today = $today->format('Y-m-d');
		$today = new DateTime($today);

		$diff = $today->diff($dateChange);
		$diff = $diff->format('%m');
		return $diff;
	}
}

?>