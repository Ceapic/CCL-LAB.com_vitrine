<?php

// no direct access
defined('_JEXEC') or die('Acces interdit');

// require_once(URL_MODELE . "Constantes.php");

class ModelGlobal {
	/**
	 * Fonction qui permet de rajouter génériquement une data dans une table
	 * @param $table => Nom de la table
	 * @param $newData => Objet qui doit être inséré
	 * @param $id_name => ??
	 * @param $debug => Permet d'afficher les erreurs
	 */
	function addItem($table, $newData, $id_name = "", $debug = false) {
		GBMNet::getDBOGBMNet()->insertObject($table, $newData, $id_name);
		$stackTrace = debug_backtrace();
		Log::saveLog($table, GBMNet::getDBOGBMNet()->insertid(), "Ajout", $newData, $stackTrace);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug) {
			throw new Exception('AJOUT ' . GBMNet::getDBOGBMNet()->getErrorMsg());
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->insertid();
	}

	function editItem($table, $newData, $id_name, $debug = 0, $priseEnCompteNull = false) {
		if ($id_name == "id") {
			$oldItem = $this->getItemNew($table, $newData->id);
		} else {
			$oldItem = $this->getItem($table, $newData->$id_name);
		}

		$diff = $this->getDifferences($oldItem, $newData);

		if (!empty(get_object_vars($diff))) {
			$stackTrace = debug_backtrace();
			Log::saveLog($table, $newData->$id_name, "Modif", $diff, $stackTrace);
		}

		$resultat = GBMNet::getDBOGBMNet()->UpdateObject($table, $newData, $id_name, $priseEnCompteNull);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug == 1) {
			throw new Exception('MODIFICATION ' . GBMNet::getDBOGBMNet()->getErrorMsg());
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return $resultat;
	}

	static function getItem($table, $id) {
		$req = "SELECT * FROM " . $table . " WHERE id_" . $table . " = " . $id;
		GBMNet::getDBOGBMNet()->setQuery($req);

		if (GBMNet::getDBOGBMNet()->getErrorNum()) {
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObject();
	}


	static function getItemNew($table, $id) {
		$req = "SELECT * FROM " . $table . " WHERE id = " . $id;
		GBMNet::getDBOGBMNet()->setQuery($req);

		if (GBMNet::getDBOGBMNet()->getErrorNum()) {
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObject();
	}

	/**
	 * Methode qui permet de récupérer un objet avec l'ancienne structure des noms de champ
	 */
	static function getObjectOld($table, $id, $class) {
		$req = "SELECT * FROM " . $table . " WHERE id_" . $table . " = " . $id;
		GBMNet::getDBOGBMNet()->setQuery($req);
		//echo $req;
		if (GBMNet::getDBOGBMNet()->getErrorNum()) {
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObject($class);
	}

	/**
	 * Méthode qui permet de récupérer un objet avec le nommage simpliste des champs
	 */
	static function getObject($table, $id, $class, $debug = 0) {
		$req = "SELECT * FROM " . $table . " WHERE id = " . $id;
		GBMNet::getDBOGBMNet()->setQuery($req);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug == 1) {
			//PAS SUR QUE SA MARCHE LE ERROR NUM AVEC LES SELECT
			throw new Exception('SELECTION ' . GBMNet::getDBOGBMNet()->getErrorMsg());
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObject($class);
	}

	function deleteItem($table, $condition, $debug = 0) {
		$query = "delete from " . $table . "
				where " . $condition;

		GBMNet::getDBOGBMNet()->setQuery($query);
		GBMNet::getDBOGBMNet()->execute();

		Log::saveLog($table, 0, "Suppression", $condition);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug == 1) {
			throw new Exception('DELETE ' . GBMNet::getDBOGBMNet()->getErrorMsg());
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
	}

	function showTable($table, $order = "", $debug = 0) {
		$query = "Select *
				from " . $table . "
				" . $order;
		GBMNet::getDBOGBMNet()->setQuery($query);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug == 1) {
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObjectList();
	}

	function showQuery($table, $where, $order = "", $debug = 0) {
		$query = "Select *
				from " . $table . "
				where " . $where . "
				" . $order;
		// echo $query;
		GBMNet::getDBOGBMNet()->setQuery($query);

		if (GBMNet::getDBOGBMNet()->getErrorNum() && $debug == 1) {
			echo GBMNet::getDBOGBMNet()->getErrorMsg();
			exit;
		}
		return GBMNet::getDBOGBMNet()->loadObjectList();
	}

	static function sendEmail(
		$configMail,
		$tos,
		$sujet,
		$corps,
		$toCcs,
		$toCcis,
		$attachments,
		$embeddedImages,
		$fromName = "",
		$string_attachements = null
	) {
		//CONFIGURATION PRINCIPALE
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = $configMail->secure; // secure transfer enabled REQUIRED for GMail
		$mail->Host = $configMail->smtp;
		$mail->Port = $configMail->port;
		$mail->Username = $configMail->mail;
		$mail->Password = $configMail->pwd;
		$mail->CharSet = "UTF-8";

		//EXPEDITEUR
		$mail->SetFrom($configMail->mail, $fromName);

		//ALIMENTATION EMAIL
		$mail->Subject = $sujet;
		$mail->MsgHTML($corps);

		//DESTINATAIRES
		if ($tos != null) {
			foreach ($tos as $to) {
				$mail->AddAddress($to);
			}
		}
		if ($toCcs != null) {
			foreach ($toCcs as $toCc) {
				$mail->addCC($toCc, "");
			}
		}
		if ($toCcis != null) {
			foreach ($toCcis as $toCci) {
				$mail->addBCC($toCci, "");
			}
		}

		//DOCUMENTS
		if ($embeddedImages != null) {
			foreach ($embeddedImages as $embImage) {
				$mail->AddEmbeddedImage($embImage->path, $embImage->name);
			}
		}

		if ($string_attachements != null) {
			foreach ($string_attachements as $string_attch) {
				$mail->AddStringAttachment($string_attch->file, $string_attch->file_name);
			}
		}


		if ($attachments != null) {
			foreach ($attachments as $attachment) {
				$mail->AddAttachment(utf8_decode($attachment->path), $attachment->name);
			}
		}



		//ENVOI EMAIL
		if (!$mail->Send()) {
			$result = 'Erreur: ' . $mail->ErrorInfo;
			echo "<script>alert('" . $result . "')</script>";
			return 0;
		} else {
			$result = 'Message envoyé';
			//echo "<script>alert('" . $result . "')</script>";
			return 1;
		}
	}

	/**
	 * Fonction qui retourne une stdClass avec les nouvelles valeurs entre 2 objets.
	 * 
	 * @param [type] $objetOld
	 * @param [type] $objetNew
	 * @return void
	 */
	function getDifferences($objetOld, $objetNew) {
		$resultat = new stdClass();
		foreach ($objetOld as $key => $value) {
			if ($objetNew->$key != $value) {
				$resultat->$key = $objetNew->$key;
			}
		}
		return $resultat;
	}

	function updateIsActif($table, $column, $id) { // A améliorer avec un array pour les columns et id
		$query = "UPDATE {$table}
			SET is_revision_active = 0
			WHERE {$column} = {$id}";

		GBMNet::getDBOGBMNet()->setQuery($query);
		GBMNet::getDBOGBMNet()->execute();

		$query = "UPDATE {$table} AS table2Update
			JOIN (
				SELECT MAX(id) AS max_id
				FROM {$table}
				WHERE {$column} = {$id}
			) AS max_ids ON table2Update.id = max_ids.max_id
			SET table2Update.is_revision_active = 1";

		GBMNet::getDBOGBMNet()->setQuery($query);
		GBMNet::getDBOGBMNet()->execute();
	}

	function newRevRapportPrlv($id_echantillon, $description = "") { // Ca ne sert à rien voir avec Nico
		$type_prlv = Constantes::TYPE_RAPPORT_PRLV;
		$type_rapport = $this->showQuery("type_rapport", "type_rapport = {$type_prlv}");

		foreach ($type_rapport as $oneTypeRapport) {
			$nomTypeRapport = $oneTypeRapport->nom_type_rapport;
			$shortNameColumn = $oneTypeRapport->nom_processus_type_rapport;

			if ($shortNameColumn == "0") {
				$idColumn = "id_{$nomTypeRapport}";
				$revisionColumn = "revision_{$nomTypeRapport}";
				$echantillonColumn = "echantillon_{$nomTypeRapport}";
				$validationColumn = "validation_{$nomTypeRapport}";
				$dateValidationColumn = "validation_{$nomTypeRapport}";
				$valideurColumn = "valideur_{$nomTypeRapport}";
				$descriptionColumn = "description_{$nomTypeRapport}";
			}

			if ($shortNameColumn == "1") {
				$idColumn = "id";
				$revisionColumn = "revision";
				$echantillonColumn = "echantillon";
				$validationColumn = "validation";
				$dateValidationColumn = "validation";
				$valideurColumn = "valideur";
				$descriptionColumn = "description";
			}

			$query = "SELECT * ";
			$query .= " FROM {$nomTypeRapport} ";
			$query .= " WHERE {$echantillonColumn} = {$id_echantillon}";
			$query .= " ORDER BY {$revisionColumn} DESC";
			$query .= " LIMIT 1";

			GBMNet::getDBOGBMNet()->setQuery($query);
			$result = GBMNet::getDBOGBMNet()->loadObjectList();

			if (GBMNet::getDBOGBMNet()->getErrorNum()) {
				echo GBMNet::getDBOGBMNet()->getErrorMsg();
				exit;
			}

			if (count($result) > 0)
				break;
		}

		if (count($result) > 0) {
			$oneRapport = $result[0];

			if ($oneRapport->$validationColumn == "1") {
				$newRapport = clone ($oneRapport);
				$newRapport->$idColumn = null;
				$newRapport->$revisionColumn = $newRapport->$revisionColumn + 1;
				$newRapport->$validationColumn = 0;
				$newRapport->$dateValidationColumn = "0000-00-00";
				$newRapport->$valideurColumn = 0;
				$newRapport->$descriptionColumn = $description;

				$newRapportId = $this->addItem($nomTypeRapport, $newRapport, $idColumn);
				return $newRapportId;
			}
		}
	}
}
