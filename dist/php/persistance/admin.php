<?php

require_once 'connectionDB.php';

	class Admin
	{

		private $id_admin;
		private $email_admin;
		private $mdp_admin;
		private $token_admin;
		private $db;
		/* Constructeur */
		public function __construct ($id_admin, $email_admin, $mdp_admin, $token_admin)
		{
			$this->db = connection();
			$this->id_admin = $id_admin;
			$this->email_admin = $email_admin;
			$this->mdp_admin = $mdp_admin;
			$this->token_admin = $token_admin;
		}

		/* Insérer un administrateur */
		public function createAdmin()
		{
			$query = $this->db->prepare("INSERT INTO Admin (id_admin, email_admin, mdp_admin, token_admin) VALUES (:id_admin, :email_admin, :mdp_admin, :token_admin);");
			$query->execute(array(
				'id_admin' => $this->id_admin,
				'email_admin' => $this->email_admin,
				'mdp_admin' => $this->mdp_admin,
				'token_admin' => $this->token_admin
				));
			return $query;
		}

		/* Changer le token de l'administrateur lors de sa connexion pour correspondre au cookie géneré */
		public function changeToken($token)
		{
			$query = $this->db->prepare("UPDATE Admin SET token_admin = :token_admin WHERE email_admin = :email_admin");
			$query->execute(array(
				'token_admin' => $token,
				'email_admin' => $this->email_admin
				));
			return $query;//->fetchAll();
		}

		/* Récupérer les administrateurs */
		public function selectAllAdmin()
		{
			$query = $this->db->prepare("SELECT id_admin, email_admin, mdp_admin, token_admin  FROM Admin");
			$query->execute();
			return $query->fetchAll();
		}

		/* Récupérer le token d'un administrateur par son ID */
		public function getTokenById()
		{
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$query = $this->db->prepare("SELECT token_admin FROM Admin WHERE id_admin = :id_admin");
			$query->execute(array(
				'id_admin' => $this->id_admin
				));
			return $query->fetchAll();
		}

		/* Savoir si l'administrateur existe et s'il peut se connecter */
		public function exist()
		{
			$query = $this->db->prepare("SELECT 1 FROM Admin WHERE email_admin = :email_admin AND mdp_admin = :mdp_admin");
			$query->execute(array(
				'email_admin' => $this->email_admin,
				'mdp_admin' => $this->mdp_admin
				));
			return count($query->fetchAll()) > 0;
		}

		public function read()
		{
			$query = $this->db->prepare("SELECT id_admin, email_admin, mdp_admin, token_admin  FROM Admin WHERE email_admin = :email_admin AND mdp_admin = :mdp_admin");
			$query->execute(array(
				'email_admin' => $this->email_admin,
				'mdp_admin' => $this->mdp_admin
				));
			return $query->fetchAll();
		}

		public function existByEmail()
		{
			$query = $this->db->prepare("SELECT id_admin, email_admin, mdp_admin, token_admin  FROM Admin WHERE email_admin = :email_admin");
			$query->execute(array(
				'email_admin' => $this->email_admin
				));
			return $query->fetchAll();
		}

		/* Changer le mot de passe de l'admin */
		public function changePassword()
		{
			$query = $this->db->prepare("UPDATE Admin SET mdp_admin = :mdp_admin WHERE id_admin = :id_admin");
			$query->execute(array(
				'mdp_admin' => $this->mdp_admin,
				'id_admin' => $this->id_admin
				));
			return $query;//->fetchAll();
		}

		/* Changer le mot de passe de l'admin */
		public function changePasswordByMail()
		{
			$query = $this->db->prepare("UPDATE Admin SET mdp_admin = :mdp_admin WHERE email_admin = :email_admin");
			$query->execute(array(
				'mdp_admin' => $this->mdp_admin,
				'email_admin' => $this->email_admin
				));
			return $query;//->fetchAll();
		}
	}