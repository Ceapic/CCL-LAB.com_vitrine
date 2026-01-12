<?php
defined('_JEXEC') or die('Accès interdit');
jimport('joomla.application.component.controller');

class CEAPICWorldController extends JControllerLegacy {

	function CheckTokenCEAPIC() {
		global $mainframe;
		$token = JRequest::getVar('token');
		$model = $this->getModel('ceapicworld'); // nom model
		$return = $model->CheckLocalToken($token);
		echo $return;
	}

	function NouveauUtilisateur() {
		$login = JRequest::getVar('login');
		$pwd = hex2bin(JRequest::getVar('pwd'));
		$client = JRequest::getVar('client');
		$type_client = JRequest::getVar('type_client');
		$iv = hex2bin(JRequest::getVar('iv'));
    $idLaboratoire = JRequest::getVar('id_laboratoire');
		$token = JRequest::getVar('token');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$checktoken = $model->CheckRemoteToken($token);
		if ($checktoken == "true") {
			$key = substr(sha1($model->GetSharingKey(), true), 0, 16);
			$model->NouveauUtilisateur(
				$login,
				openssl_decrypt($pwd, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				$client,
				$type_client, 
        $idLaboratoire
			);
		} else {
			echo "false";
		}
	}

	function ModifierUtilisateur() {
		$login = JRequest::getVar('login');
		$pwd = JRequest::getVar('pwd');
		$client = JRequest::getVar('client');
		$type_client = JRequest::getVar('type_client');
    $idLaboratoire = JRequest::getVar('id_laboratoire');
		$iv = hex2bin(JRequest::getVar('iv'));
		$token = JRequest::getVar('token');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$checktoken = $model->CheckRemoteToken($token);
		if ($checktoken == "true") {
			$user = $model->ListeUtilisateurClient($client, $type_client, $idLaboratoire);

			if (count($user) != 0) {
				$model->ModifierLoginUtilisateur($user[0]->id, $login);

				if ($pwd != "") {
					$pwd = hex2bin($pwd);
					$key = substr(sha1($model->GetSharingKey(), true), 0, 16);
					$model->ModifierPWDUtilisateur($user[0]->id, openssl_decrypt($pwd, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
				}
			} else {
				// echo "test";
				$pwd = hex2bin($pwd);
				$key = substr(sha1($model->GetSharingKey(), true), 0, 16);
				$model->NouveauUtilisateur(
					$login,
					openssl_decrypt($pwd, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
					$client,
					$type_client, 
          $idLaboratoire
				);
			}
		} else {
			echo "false TOKEN";
		}
	}

	function NouveauClient() {
		$token = JRequest::getVar('token');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$checktoken = $model->CheckRemoteToken($token);
		if ($checktoken == "true") {
			$ref_client = JRequest::getVar('ref_client');
			$nom_client = JRequest::getVar('nom_client');
			$siret_client = JRequest::getVar('siret_client');
			$telephone_client = JRequest::getVar('telephone_client');
			$adresse_client = JRequest::getVar('adresse_client');
			$ville_client = JRequest::getVar('ville_client');
			$cp_client = JRequest::getVar('cp_client');
			$adresse_facturation_client = JRequest::getVar('adresse_facturation_client');
			$ville_facturation_client = JRequest::getVar('ville_facturation_client');
			$cp_facturation_client = JRequest::getVar('cp_facturation_client');
			$mail_client = JRequest::getVar('mail_client');
			$fax_client = JRequest::getVar('fax_client');
			$disable_client = JRequest::getVar('disable_client');
			$iv = hex2bin(JRequest::getVar('iv'));

			$key = substr(sha1($model->GetSharingKey(), true), 0, 16);

			$return = $model->NouveauClient(
				openssl_decrypt(rawurldecode($ref_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($nom_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($siret_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($telephone_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($adresse_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($ville_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($cp_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($adresse_facturation_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($ville_facturation_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($cp_facturation_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($mail_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($fax_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv),
				openssl_decrypt(rawurldecode($disable_client), 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv)
			);
			echo $return;
		} else {
			echo  "FALSE";
		}
	}

	function ListeStrategieChantier() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$tokenclient = JRequest::getVar('tokenclient');
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$id_chantier = JRequest::getVar('id_chantier');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeStrategieChantier&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function ListeRevisionStrategieChantier() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$tokenclient = JRequest::getVar('tokenclient');
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$id_echantillon = JRequest::getVar('id_echantillon');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeRevisionStrategieChantier&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function Commander() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$tokenclient = JRequest::getVar('tokenclient');
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$id_echantillon = JRequest::getVar('id_echantillon');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=Commander&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function BonCommande() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');
		$id_strategie = JRequest::getVar('id_strategie');
		$tokenstrategie = JRequest::getVar('tokenstrategie');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_strategie . $sharingkey) == $tokenstrategie)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=BonCommande&id_strategie=" . $id_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$excel = file_get_contents($url);
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename=CEAPIC BdC.xlsx');
			ob_clean();
			flush();
			echo $excel;
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function ListeRapportChantier() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$tokenclient = JRequest::getVar('tokenclient');
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$id_chantier = JRequest::getVar('id_chantier');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ListeRapportChantier&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function SuiviStrategieLoader() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$tokenclient = JRequest::getVar('tokenclient');
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$id_chantier = JRequest::getVar('id_chantier');
		$id_echantillon = JRequest::getVar('id_echantillon');
		$id_strategie = JRequest::getVar('id_strategie');
		$ref_strategie = JRequest::getVar('ref_strategie');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();
		// var_dump("laaaaaaaa2");
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			// var_dump($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=SuiviStrategieLoader&id_echantillon=" . $id_echantillon . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
			echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=SuiviStrategieLoader&id_echantillon=" . $id_echantillon . "&id_strategie=" . $id_strategie . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	// function AfficheRapportEchantillon() {
	// 	$id_client = JRequest::getVar('id_client');
	// 	$type_client = JRequest::getVar('type_client');
	// 	$tokenclient = JRequest::getVar('tokenclient');

	// 	$id_echantillon = JRequest::getVar('id_echantillon');
	// 	$tokenechantillon = JRequest::getVar('tokenechantillon');
	// 	$ref = JRequest::getVar('ref');
	// 	global $mainframe;
	// 	$model = $this->getModel('ceapicworld'); // nom model
	// 	$sharingkey = $model->GetSharingKey();

	// 	if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_echantillon . $sharingkey) == $tokenechantillon)) {
	// 		$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
	// 		$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheRapportEchantillon&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

	// 		$pdf = file_get_contents($url);
	// 		header("Content-Type: application/pdf");
	// 		header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
	// 		ob_clean();
	// 		flush();
	// 		echo $pdf;
	// 	}
	// }

	function AfficheRapportEchantillon() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenClient = JRequest::getVar('tokenClient');

		$id_mission = JRequest::getVar('id_mission');
		$tokenMission = JRequest::getVar('tokenMission');

		$id_echantillon = JRequest::getVar('id_echantillon');
		$tokenEchantillon = JRequest::getVar('tokenEchantillon');
		$ref = JRequest::getVar('ref');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if (
			(md5($id_client . $type_client . $sharingkey) == $tokenClient) &&
			((md5($id_echantillon . $sharingkey) == $tokenEchantillon) || (md5($id_mission . $sharingkey) == $tokenMission))
		) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheRapportEchantillon&id_echantillon={$id_echantillon}&id_mission={$id_mission}&id_client={$id_client}&token={$token}&format=raw";

			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}/* else {
			var_dump(md5($id_client . $type_client . $sharingkey));
			var_dump($tokenClient);
			var_dump(md5($id_echantillon . $sharingkey));
			var_dump($tokenEchantillon);
			var_dump(md5($id_mission . $sharingkey));
			var_dump($tokenMission);
			var_dump("Erreur de sécurité");
		}*/
	}

	function AfficheRapport() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$id_echantillon = JRequest::getVar('id_echantillon');
		$id_rapport = JRequest::getVar('id_rapport');
		$tokenrapport = JRequest::getVar('tokenrapport');
		$ref = JRequest::getVar('ref');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_rapport . $sharingkey) == $tokenrapport)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheRapport&id_echantillon=" . $id_echantillon . "&id_rapport=" . $id_rapport . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	function AfficheRapportFinal() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$id_echantillon = JRequest::getVar('id_echantillon');
		$id_rapport = JRequest::getVar('id_rapport');
		$tokenrapport = JRequest::getVar('tokenrapport');
		$ref = JRequest::getVar('ref');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_rapport . $sharingkey) == $tokenrapport)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheRapportFinal&id_echantillon=" . $id_echantillon . "&id_rapport=" . $id_rapport . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	function AfficheStrategie() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$id_strategie = JRequest::getVar('id_strategie');
		$type_strategie = JRequest::getVar('type_strategie');
		$ref = JRequest::getVar('ref');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheStrategie&id_strategie=" . $id_strategie . "&type_strategie=" . $type_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	function AfficheAnalyseEchantillon() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$typeAnalyse = JRequest::getVar('typeAnalyse');
		$id = JRequest::getVar('id');

		$tokenechantillon = JRequest::getVar('tokenechantillon');
		$ref = JRequest::getVar('ref');
		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		//echo $sharingkey;
		//echo "<br/>";
		//echo $tokenechantillon;
		//echo "<br/>";
		//echo md5($id.$sharingkey);
		//echo "<br/>";
		//die();

		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id . $sharingkey) == $tokenechantillon)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=AfficheAnalyseEchantillon&typeAnalyse=" . $typeAnalyse . "&id=" . $id . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
			//echo $url;

			$pdf = file_get_contents($url);
			//echo $pdf;
			//die();

			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		} else {

			echo "Erreur Token";
		}
	}

	function Extraction() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$id_chantier = JRequest::getVar('id_chantier');
		$date_debut = JRequest::getVar('debut_extraction');
		$date_fin = JRequest::getVar('fin_extraction');
		$tokenchantier = JRequest::getVar('tokenchantier');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		$date_extract = date("Y-m-d H-i");

		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_chantier . $type_client . $sharingkey) == $tokenchantier) && ($id_chantier <> "0")) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=Extraction&id_chantier=" . $id_chantier . "&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$excel = file_get_contents($url);

			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename="Extraction-' . $date_extract . '.xlsx"');
			ob_clean();
			flush();
			echo $excel;
		}
	}

	function ExtractionAnalyseDate() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$date_debut = JRequest::getVar('date_debut');
		$date_fin = JRequest::getVar('date_fin');

		$type_extract = JRequest::getVar('type_extract');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model		
		$sharingkey = $model->GetSharingKey();

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=ExtractionAnalyseDate&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&type_extract=" . $type_extract . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
			//echo $url;

			$excel = file_get_contents($url);

			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename=extract.xlsx');
			ob_clean();
			flush();
			echo $excel;
		}
	}

	function DownloadAllRapportChantier() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');
		$id_chantier = JRequest::getVar('id_chantier');
		$ref_chantier = JRequest::getVar('ref_chantier');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=DownloadAllRapportChantier&id_chantier=" . $id_chantier . "&type_rapport=" . $type_client . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			header('Content-Disposition: attachment; filename=RapportsChantier_' . $ref_chantier . '.zip');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	function DownloadAllRapportChantier2() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');
		$id_chantier = JRequest::getVar('id_chantier');
		$ref_chantier = JRequest::getVar('ref_chantier');

		global $mainframe;
		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "/index.php?option=com_ceapicworld&task=DownloadAllRapportChantier&id_chantier=" . $id_chantier . "&type_rapport=" . $type_client . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			// header('Content-Disposition: attachment; filename=RapportsChantier_'.$ref_chantier.'.zip');
			// ob_clean();
			// flush();
			echo $pdf;
		}
	}

	function SendReservation() {
		$id_client = JRequest::getVar('id_client');
		$type_client = JRequest::getVar('type_client');
		$tokenclient = JRequest::getVar('tokenclient');

		$agence_chantier = JRequest::getVar('agence');
		$data_reservation = JRequest::getVar('data_reservation');
		$destinataire = JRequest::getVar('destinataire');
		$contact_mail = JRequest::getVar('contact_mail');
		$contact_chantier = JRequest::getVar('contact_chantier');
		$ville_chantier = JRequest::getVar('ville_chantier');

		$destinataire = explode(";", $destinataire);
		$contact_mail = explode("|", $contact_mail);
		$contact_chantier = explode("|", $contact_chantier);

		$model = $this->getModel('ceapicworld'); // nom model
		$sharingkey = $model->GetSharingKey();

		// $Body = "<div> <div> <span style='font-family:David;color:#1F497D;'><b>Emetteur :</b><br/>&nbsp;&nbsp;" . $destinataire[1] . " " . $destinataire[0] . "<br/>&nbsp;&nbsp;" . $destinataire[2] . "<br>&nbsp;&nbsp;" . $destinataire[3] . "<br/><br/></div>";


		$Body = '<style>
				.div {
					border: solid 1px blue;
					margin: 5px;
					padding: 5px;
				}

				.divPrincipal {
					display: flex;
					justify-content: flex-start;
				}

				table,
				table td				
				{
					border: solid 1px black;
					padding:5px;
				}

				.tableForm td,				
				.tableForm tr,				
				.tableForm {
					border: none;
					padding: 0px;
					vertical-align: top;
				}

				.gbmnet_table {
					border-collapse: collapse !important;
					text-align:center;
				}

				.reservation {
					margin-top: 15px;
					border-collapse: collapse;
				}

				.reservation .tr_titre {
					background: #F2F2F2;
				}

				.reservation .span_titre {
					font-size: 12pt;
					color: #0070C0;
					font-family: arial;
					font-weight: bold;
				}

				.reservation TD {
					border: 1px solid;
					padding: 5px;
					text-align: center;
				}
			</style>';

		$Body .= '<div class="divPrincipal">
				<table class="tableForm">
					<tr>
					<td>
					<div class="div" >
						<span style="font-family:David;color:#1F497D;"><b>Emetteur :</b> <br />
						&nbsp;&nbsp;' . $destinataire[1] . ' ' . $destinataire[0] . ' <br />
						&nbsp;&nbsp;' . $destinataire[2] . '<br/>
						&nbsp;&nbsp;' . $destinataire[3] . '<br />					
						</span>
					</div>
					</td> ';

		$Body .= '<td><div class="div" ><span style="font-family:David;color:#1F497D;"><b>Contact chantier :</b><br/>';
		foreach ($contact_chantier as $one_contact_chantier) {
			$one_contact_chantier = explode(";", $one_contact_chantier);
			$Body .= "&nbsp;&nbsp;" . $one_contact_chantier[1] . " " . $one_contact_chantier[0] . " : " . $one_contact_chantier[2] . " / " . $one_contact_chantier[3] . "<br/>";
		}
		$Body .= "</span></div></td></tr></table></div>";

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			// echo str_replace("[lt]", "<", str_replace("[gt]", ">",$data_reservation));
			$mail = JFactory::getMailer();
			$mail = new PHPMailer();  // create a new object
			$mail->IsSMTP(); // enable SMTP
			$mail->IsHTML = true; // enable HTML
			// $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = true;  // authentication enabled
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
			$mail->Host = 'SSL0.OVH.NET';
			$mail->Port = 465;
			if ($agence_chantier == "2") {
				$mail->Username = "ris.lyon@ceapic.fr";
				$mail->Password = "NpfAYidl8$";
				$mail->SetFrom("ris.lyon@ceapic.fr", "planning CEAPIC");
			} else {
				$mail->Username = "exploitation@ceapic.fr";
				$mail->Password = "mlehbili14";
				$mail->SetFrom("exploitation@ceapic.fr", "Exploitation CEAPIC");
			}

			$mail->CharSet = "UTF-8";
			$mail->Subject = "Réservation - " . $ville_chantier;
			$Body .= str_replace("[lt]", "<", str_replace("[gt]", ">", $data_reservation));
			$Body .= "<br/>
			Vous en souhaitant bonne réception.
			<br/>
			Cette adresse mail n’est pas consultée. Ne pas répondre à ce mail. Pour toute demande, contacter vos interlocuteurs habituels.			
			<br/>
			Cordialement,<br/>
			<br/>
			Laboratoire CEAPIC<br/>";
			if ($agence_chantier == 2) {
				$Body .= "
				51 rue Audibert et Lavirotte <br/>69008 LYON</span>";
			} else {
				$Body .= "
				13 Rue Louis Armand<br/>95230 Soisy-Sous-Montmorency</span>";
			}

			$mail->MsgHTML($Body);

			if ($agence_chantier == 2) {
				$mail->AddAddress("ris.lyon@ceapic.fr");
				// $mail->AddAddress("ceapic.exploitation.lyon@gmail.com");
			} else {
				$mail->AddAddress("exploitation@ceapic.fr");
				// $mail->AddAddress("ceapic.exploitation@gmail.com");
			}

			$mail->AddCC($destinataire[3]);
			if ($destinataire[4] <> "") $mail->AddCC($destinataire[4]);

			foreach ($contact_mail as $one_contact_mail) {
				$mail->AddCC($one_contact_mail);
			}

			foreach ($contact_chantier as $one_contact_chantier) {
				$one_contact_chantier = explode(";", $one_contact_chantier);
				$mail->AddCC($one_contact_chantier[3]);
			}

			if (!$mail->Send()) {
				// echo 'Erreur: '.$mail->ErrorInfo;
				echo 'false';
			} else {
				$model->LogHistory(0, $id_client, $type_client, 1, '');
				echo 'true';
			}
		}
	}
}
