<?php
/**
* @file 		/Modele_Usagers.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
	* @class 	Modele_Usagers - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Usagers a la BD
	*					- definit les requetes specifiques a la classe
	*
***	* 	15 methodes	|	getTableName(), obtenir_par_id(), obtenir_tous(), sauvegarder(), retirer(), authentification(), 
	*					misAjourChampUnique(), definir_role_usager(), obtenir_avec_role(), definir_admin(), getModePaiement(), 
	* 					getModeCommunication(), obtenir_avec_paiement_communication(), filtrer_les_usagers(), editerChampProfil()
	*/
	class Modele_Usagers extends BaseDAO
	{	

		/**  
		* @brief     	Renvoie le nom de la table usager
		* @details   	Retourne le nom de la table contenant les usagers pour la BD 
		* @param   		Aucun
		* @return    	Le nom de la table usager
		*/
		public function getTableName()
		{
			return "usager";
		}
				
		/**  
		* @brief     	Lecture d'un usager de la BD
		* @details   	Exécute la lecture d'un usager de la BD à l'aide de son identifiant 
		* @param   		<string> 	$username 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenir_par_id($username) {
			$resultat = $this->lire($username);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usager'); 
			$lUsager = $resultat->fetch();
            $this->obtenir_avec_role($lUsager);
			return $lUsager;
		}
				
		/**  
		* @brief     	Lecture des usagers de la BD
		* @details   	Exécute la lecture de tous les usagers de la BD 
		* @param   		Aucun
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenir_tous() {
            $resultat = $this->lireTous();
			$lesUsagers = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
            foreach($lesUsagers as $usager)
            {
                $this->obtenir_avec_role($usager);
            }

			return $lesUsagers;
		}
	
		/**  
		* @brief     	Sauvegarder la modification ou l'ajout d'un usager à la BD
		* @details   	Inscrire la modification ou la création d'un usager à la BD
		* @param   		<objet>		$lUsager 		Objet Usager
		* @return    	Résultat de la requête SQL
		*/ 
		public function sauvegarder(Usager $lUsager) {
			if($lUsager->getUsername() && $this->lire($lUsager->getUsername())->fetch())
			{
				// Sauvegarde de la modification de l'usager
				$query = "UPDATE " . $this->getTableName() . " SET nom=?, prenom=?, photo=?, adresse=?, telephone=?, motDePasse=?, id_moyenComm=?, id_modePaiement=? WHERE " . $this->getClePrimaire() . "=?";
				$donnees = array($lUsager->getNom(), $lUsager->getPrenom(), $lUsager->getPhoto(), $lUsager->getAdresse(), $lUsager->getTelephone(), $lUsager->getMotDePasse(), $lUsager->getIdMoyenComm(), $lUsager->getIdModePaiement(), $lUsager->getUsername());
				return $this->requete($query, $donnees);
				
			}
			else
			{
				// Sauvegarde de l'ajout de l'usager
				$query = "INSERT INTO " . $this->getTableName() . "(username, nom, prenom, photo, adresse, telephone, motDePasse, id_moyenComm, coor_moyenComm, id_modePaiement ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$donnees = array($lUsager->getUsername(), $lUsager->getNom(), $lUsager->getPrenom(), $lUsager->getPhoto(), $lUsager->getAdresse(), $lUsager->getTelephone(), $lUsager->getMotDePasse(), $lUsager->getIdMoyenComm(), $lUsager->getCoorMoyenComm(), $lUsager->getIdModePaiement());
				return $this->requete($query, $donnees);
			}
		}

		/**  
		* @brief     	Supprimer un usager de la BD
		* @details   	Exécute la suppression d'un usager de la BD 
		* @param   		<string>		$username 		Identifiant de l'usager
		* @return    	<bool>			résultat de la requete SQL
		*/
		public function retirer($username) {
		  	$resultat = $this->supprimer($username);
			return $resultat;
		}
        
        /**
		* @brief		Fonction pour authentifier l'usager 
		* @details		Permet de trouver l'usager qui a le username et le mot de passe entrés en paramètres;
		*				si cet usager existe, authentifie l'usager
		* @param 		<string>		$username			nom d'utilisateur
		* @param 		<string>		$password			mot de passe
		* @return    	<bool>			résultat de la requete
		*/       
		public function authentification($username, $password)
		{
			$query = "SELECT * from " . $this->getTableName() . " WHERE username = ? AND motDePasse = ?";
			$donnees = array($username, $password);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usager'); 
			if($leUsager = $resultat->fetch())
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
        
        /**
		* @brief		Fonction pour changer le statut d'un usager
		* @details		Permet de changer le statut : Banni / non banni ou Admin / non admin
		* @param 		<VAR>		$leChamp		Le champ à modifier (isBanned / isAdmin)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id d'usager dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}
        
        /**  
		* @brief     	Definir un ou plusieurs roles associes a un usager
		* @details   	Cette fonction attribue un ou plusieurs roles a un usager
		* @param   		<string>		$idUsager 		id d'un Usager
		* @param   		<array>			$tabRoles 		tableau des differents roles
		* @return    	<bool>			Résultat de la requête SQL
		*/
		public function definir_role_usager($idUsager, $idRole) {

				$query = "INSERT INTO role_user VALUES (?, ?);";
				$donnees = array($idUsager, $idRole);
				return $this->requete($query, $donnees);	
		}

        /**
		* @brief		Fonction pour effectuer une jointure entre l'usager et son role
		* @details		Permet de recuperer toutes les informations relative à un usager
		* @param 		<objet>		$usager	 		une instance d'usager	
		* @return    	<...> 		les rangées correspondant à un usager donné
		*/
		public function obtenir_avec_role($usager)
        {
            $query = "SELECT * from role_user JOIN role ON id_nomRole = id WHERE id_username = ?";
            $donnees = array($usager->getUsername());
            $resultat = $this->requete($query, $donnees);
            $usager->roles = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
        }
       
        /**
		* @brief		Fonction qui donne ou enleve les droits d'admin a un usager
		* @details		Cette fonction n'est accessible qu'au superAdmin
		* @param 		<string>		$usager			l'id de lusager	
		* @return    	<bool> 			Le résultat de la requete
		*/
        public function definir_admin($usager)
        {
			$query = "SELECT * from role_user WHERE id_username =? AND id_nomRole =2";
			$donnees = array($usager);
			if($this->requete($query, $donnees)->fetch())
            {
                $query = "DELETE FROM role_user WHERE id_username =? AND id_nomRole =2";
                $donnees = array($usager);
                return $this->requete($query, $donnees);
            }
            else
            {
                $query = "INSERT INTO role_user (id_username, id_nomRole) VALUES (?, 2)";
				$donnees = array($usager);
				return $this->requete($query, $donnees); 
            }
        }

        /**
		* @brief		Lecture des modes de paiements de la BD
		* @details		Permet de recuperer tous les modes de paiement dans la table paiement, ou un seul associe a un usager
		* @param 		<string> 	$idUsager 		L'id d'un usager - parametre facultatif	
		* @return    	<type> 		si param: 	toutes les rangées de la table paiement ou false 
		*							sinon: 		le mode de communication d'un usager
		*/
		public function getModePaiement($usager = '')  {
			$query = "SELECT id, modePaiement from paiement p";
            if(isset($usager) && !empty($usager)) {
                $query .= " JOIN usager u ON p.id = u.id_modePaiement WHERE username = ?";
                $donnees = array($usager);
                $resultat = $this->requete($query, $donnees);
                $paiement = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
                return $paiement;
            }
            else {
                return $this->requete($query);
            }
		}

		/**
		* @brief		Lecture des moyens de communication de la BD
		* @details		Permet de recuperer tous les moyens de communication dans la table communication, ou un seul associe a un usager
		* @param 		<string> 	$idUsager 		L'id d'un usager - parametre facultatif	
		* @return    	<type> 		si param: 	toutes les rangées de la table communication ou false 
		*							sinon: 		le mode de communication d'un usager
		*/
		public function getModeCommunication($idUsager = "") {
			$query = "SELECT id, moyenComm	from communication c";
            if(isset($idUsager) && !empty($idUsager)) {
                $query .= " JOIN usager u ON c.id = u.id_moyenComm  WHERE username = ?";
                $donnees = array($idUsager);
				$resultat = $this->requete($query, $donnees);
                $communication = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
                return $communication;
            }
            else {
                return $this->requete($query);
            }
        }
        
        /**
		* @brief		Lecture du moyen de communication et de paiement d'un usager
		* @details		Permet de recuperer le moyen de communication et de paiement associe a un usager
		* @param 		<string> 	$idUsager 		L'id d'un usager - parametre facultatif	
		* @return    	<boolean> 	resultat de la requete ou false	
		*/
        public function obtenir_avec_paiement_communication($idUsager) {
            $query = "SELECT * FROM usager u JOIN communication c ON c.id = u.id_moyenComm JOIN paiement p ON p.id = u.id_modePaiement WHERE u.username = ?";
            $donnees = array($idUsager);
            $resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usager'); 
			$lUsager = $resultat->fetch();
            return $lUsager;
        }

        /**
		* @brief		Fonction qui construit une requete a partir des differents roles et permissions requis pour l'usager
		* @details		
		* @param 		<array> 	$filtre  	les roles et permissions requis		
		* @return    	<...> 		resultat de la requete ou false	
		*/
        public function filtrer_les_usagers($filtre){
            $query = "SELECT * FROM " . $this->getTableName() . " u 
                        JOIN role_user ru ON u.username = id_username 
                        JOIN role r ON ru.id_nomRole = r.id";
            
            if(isset($filtre['role'])&& !empty($filtre['role']))
            {
                $query .= " WHERE r.nomRole ='".$filtre['role']."'";
            }
            if(isset($filtre['valide'])&& !empty($filtre['valide']))
            {
                $query .= " AND u.valideParAdmin	 = 1";
            }
            if(isset($filtre['attente'])&& !empty($filtre['attente']))
            {
                $query .= " AND u.valideParAdmin	 = 0";
            }
            if(isset($filtre['banni'])&& !empty($filtre['banni']))
            {
                $query .= " AND u.banni	 = 1";
            }
            $query .= " GROUP BY u.username";
            
            $resultat = $this->requete($query);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
            $lesUsagers = $resultat->fetchAll();
            foreach($lesUsagers as $usager)
            {
                $this->obtenir_avec_role($usager);
            }

			return $lesUsagers;
        }

        /**
		* @brief      	Met a jour la valeur d'une colonne specifique dans une table
		*				la valeur d'une colonne specifique dans une table 
		* @param      	<varchar>  		$champ     	Titre du champ
		* @param      	<varchar>  		$val     	Valeur du champ 
		* @param      	<varchar>  		$id     	L'id de l'Appartement
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
		public function editerChampProfil($champ, $val, $id) {
			
			$query = "UPDATE " . $this->getTableName() . " SET " . $champ . " = ? WHERE " . $this->getClePrimaire() . " = ?";			
			$donnees = array($val, $id);
			return $this->requete($query, $donnees);
		}
	}   
?>