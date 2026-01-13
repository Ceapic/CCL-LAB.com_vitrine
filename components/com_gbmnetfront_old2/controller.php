<?php

defined('_JEXEC') or die;

//require_once(URL_MODELE . "gbmnetfront.php");
// require_once(URL_MODELE . "back.php");
// require_once(URL_MODELE . "strategie.php");
// require_once(URL_MODELE . "synthese.php");
// require_once(URL_MODELE . "global.php");

//$model = new Gbmnetfront();
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
//defined('_JEXEC') or die('Restricted access');
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class GbmnetfrontController extends JControllerLegacy {

	///////////////////////////////////////////////////////// FRONT //////////////////////////////////////////////////
	function CheckToken() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$token = $input->get('token', '', 'string');
		$model = new Gbmnetfront();
		echo $model->CheckLocalToken($token);
	}

	function test() {
		$model = new Gbmnetfront();
		$return = $model->CheckLocalToken('2147483647');
		return $return;
	}

	function ListeStrategieChantierFront() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$app = JFactory::getApplication();
		$input = $app->input;
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_client = $input->get('id_client', '', 'int');
		$type_client = $input->get('type_client', '', 'int');
		$id_chantier = $input->get('id_chantier', '', 'int');
		
		global $mainframe;
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		// md5($id_client . $type_client . $sharingkey) 555
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "&task=ListeStrategieChantierBack&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}


	function SuiviStrategieLoaderFront() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$app = JFactory::getApplication();
		$input = $app->input;
		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $id_chantier = JRequest::getVar('id_chantier');
		$id_chantier = $input->get('id_chantier', '', 'int');
		// $id_echantillon = JRequest::getVar('id_echantillon');
		$id_echantillon = $input->get('id_echantillon', '', 'int');

		// $id_strategie = JRequest::getVar('id_strategie');
		$id_strategie = $input->get('id_strategie', '', 'int');

		// $ref_strategie = JRequest::getVar('ref_strategie');
		$ref_strategie = $input->get('ref_strategie', '', 'string');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		// var_dump("laaaaaaaa2");
		// md5($id_client . $type_client . $sharingkey) 555
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			// var_dump($model->GetRemoteToken() . "&task=SuiviStrategieLoader&id_echantillon=" . $id_echantillon . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
			echo file_get_contents($model->GetRemoteToken() . "&task=SuiviStrategieLoaderBack&id_echantillon=" . $id_echantillon . "&id_strategie=" . $id_strategie . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	function ListeRapportChantierFront() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$app = JFactory::getApplication();
		$input = $app->input;
		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $id_chantier = JRequest::getVar('id_chantier');
		$id_chantier = $input->get('id_chantier', '', 'int');
		global $mainframe;

		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		// md5($id_client . $type_client . $sharingkey) 555
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			echo file_get_contents($model->GetRemoteToken() . "&task=ListeRapportChantierBack&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}


	function AfficheRapportFront() {
		$app = JFactory::getApplication();
		$input = $app->input;
		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $id_echantillon = JRequest::getVar('id_echantillon');
		$id_echantillon = $input->get('id_echantillon', '', 'int');

		$id_rapport = $input->get('id_rapport', '', 'int');
		$tokenrapport = $input->get('tokenrapport', '', 'string');

		$ref = $input->get('ref', '', 'string');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		//md5($id_client . $type_client . $sharingkey) 555
		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_rapport . $sharingkey) == $tokenrapport)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=AfficheRapportBack&id_echantillon=" . $id_echantillon . "&id_rapport=" . $id_rapport . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			// var_dump($pdf);
			// die();
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	function AfficheRapportEchantillonFront() {
		$app = JFactory::getApplication();
		$input = $app->input;
		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		$id_mission = $input->get('id_mission', '', 'int');
		$tokenMission = $input->get('tokenMission', '', 'string');

		$id_echantillon = $input->get('id_echantillon', '', 'int');
		$tokenEchantillon = $input->get('tokenEchantillon', '', 'string');

		$ref = $input->get('ref', '', 'string');
		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		//md5($id_client . $type_client . $sharingkey) 555
		if (
			(md5($id_client . $type_client . $sharingkey) == $tokenclient) &&
			((md5($id_echantillon . $sharingkey) == $tokenEchantillon) || (md5($id_mission . $sharingkey) == $tokenMission))
		) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=AfficheRapportEchantillon&id_echantillon={$id_echantillon}&id_mission={$id_mission}&id_client={$id_client}&token={$token}&format=raw";

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
	function DownloadAllRapportChantierFront() {
		$app = JFactory::getApplication();
		$input = $app->input;

		$id_client = $input->get('id_client', '', 'int');
		$type_client = $input->get('type_client', '', 'int');
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_chantier = $input->get('id_chantier', '', 'int');
		$ref_chantier = $input->get('ref_chantier', '', 'string');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		//md5($id_client . $type_client . $sharingkey) 555
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=DownloadAllRapportChantierBack&id_chantier=" . $id_chantier . "&type_rapport=" . $type_client . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$zipPathOrUrl = trim(file_get_contents($url));

			$filename = 'RapportsChantier_' . $ref_chantier . '.zip';
			$zipData = file_get_contents($zipPathOrUrl);
			$size = strlen($zipData);

			while (ob_get_level()) {
				ob_end_clean();
			}

			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Length: ' . $size);
			header('Pragma: public');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

			echo $zipData;
		}
	}


	////////////////////////////////////////////  TelechargeStrategie  ///////////////////////////////////////////
	function AfficheStrategieFront() {
		// die('sui');
		$app = JFactory::getApplication();
		$input = $app->input;
		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_strategie = JRequest::getVar('id_strategie');
		$id_strategie = $input->get('id_strategie', '', 'int');

		// $type_strategie = JRequest::getVar('type_strategie');
		$type_strategie = $input->get('type_strategie', '', 'int');

		// $ref = JRequest::getVar('ref');
		$ref = $input->get('ref', '', 'string');
		global $mainframe;
		// $model = $this->getModel('ceapicworld'); nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		//555
		// echo "$tokenclient";
		// echo "|||||||";
		// echo md5($id_client . $type_client . $sharingkey);
		// echo "wtf";
		// die("$type_strategie");
		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=AfficheStrategieBack&id_strategie=" . $id_strategie . "&type_strategie=" . $type_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}

	////////////////////////////////////////////////// commander /////////////////////////////////////////////////////

	function CommanderFront() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$app = JFactory::getApplication();
		$input = $app->input;
		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_echantillon = $input->get('id_echantillon', '', 'string');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		//md5($id_client . $type_client . $sharingkey) 555

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			// var_dump($model->GetRemoteToken() . "&task=CommanderBack&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
			echo file_get_contents($model->GetRemoteToken() . "&task=CommanderBack&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}


	///////////////////////////////////////////////// Extraction ////////////////////////////////////////////////////////////
	function ExtractionFront() {
		// die();
		$app = JFactory::getApplication();
		$input = $app->input;
		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_chantier = JRequest::getVar('id_chantier');
		$id_chantier = $input->get('id_chantier', '', 'int');

		// $date_debut = JRequest::getVar('debut_extraction');
		$date_debut = $input->get('debut_extraction', '', 'date');

		// $date_fin = JRequest::getVar('fin_extraction');
		$date_fin = $input->get('fin_extraction', '', 'date');

		// $tokenchantier = JRequest::getVar('tokenchantier');
		$tokenchantier = $input->get('tokenchantier', '', 'string');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();

		$date_extract = date("Y-m-d H-i");
		//md5($id_client . $type_client . $sharingkey) 555
		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_chantier . $type_client . $sharingkey) == $tokenchantier) && ($id_chantier <> "0")) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=ExtractionBack&id_chantier=" . $id_chantier . "&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$excel = file_get_contents($url);

			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename="Extraction-' . $date_extract . '.xlsx"');
			ob_clean();
			flush();
			echo $excel;
		}
	}

	///////////////////////////////////////////////////// BonCommande /////////////////////////////////////////////////////////
	function BonCommandeFront() {
		// JRequest::checkToken('GET') or die( 'Invalid Token' );
		$app = JFactory::getApplication();
		$input = $app->input;
		// $id_client = JRequest::getVar('id_client');
		$id_client = $input->get('id_client', '', 'int');

		// $type_client = JRequest::getVar('type_client');
		$type_client = $input->get('type_client', '', 'int');

		// $tokenclient = JRequest::getVar('tokenclient');
		$tokenclient = $input->get('tokenclient', '', 'string');

		// $id_strategie = JRequest::getVar('id_strategie');
		$id_strategie = $input->get('id_strategie', '', 'int');

		// $tokenstrategie = JRequest::getVar('tokenstrategie');
		$tokenstrategie = $input->get('tokenstrategie', '', 'int');

		global $mainframe;
		// $model = $this->getModel('ceapicworld');  nom model
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();
		// md5($id_client . $type_client . $sharingkey) 555
		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_strategie . $sharingkey) == $tokenstrategie)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=BonCommandeBack&id_strategie=" . $id_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$excel = file_get_contents($url);
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename=LEPBI BdC.xlsx');
			ob_clean();
			flush();
			echo $excel;
		} else {
			die('Erreur de s&eacute;curit&eacute;');
		}
	}

	////////////////////////////////////////////////////// mes-rapport-finaux ////////////////////////////////////////////
	function AfficheRapportFinalFront() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_client = $input->get('id_client', '', 'int');
		$type_client = $input->get('type_client', '', 'int');

		$id_rapport = $input->get('id_rapport', '', 'int');
		$id_echantillon = $input->get('id_echantillon', '', 'int');
		$tokenrapport = $input->get('tokenrapport', '', 'int'); // here this might need to be a string so check it out later
		$ref = $input->get('ref', '', 'int');


		global $mainframe;
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();

		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id_rapport . $sharingkey) == $tokenrapport)) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=AfficheRapportFinalBack&id_echantillon=" . $id_echantillon . "&id_rapport=" . $id_rapport . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

			$pdf = file_get_contents($url);
			header("Content-Type: application/pdf");
			header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			ob_clean();
			flush();
			echo $pdf;
		}
	}


	/////////////////////////////////////////////////////// mes-dossier ////////////////////////////////////////////////////
	function AfficheAnalyseEchantillonFront() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_client = $input->get('id_client', '', 'int');
		$type_client = $input->get('type_client', '', 'int');

		$typeAnalyse = $input->get('typeAnalyse', '', 'string');
		$id = $input->get('id', '', 'int');

		$tokenechantillon = $input->get('tokenechantillon', '', 'string');
		$ref = $input->get('ref', '', 'int');
		global $mainframe;
		$model = new Gbmnetfront();
		$sharingkey = $model->GetSharingKey();

		// echo $sharingkey;
		// echo "<br/>";
		// echo $tokenechantillon;
		// echo "<br/>";
		// echo md5($id_echantillon . $sharingkey);
		// echo "<br/>";
		// var_dump($id);
		// var_dump($tokenechantillon);
		// die();
		if ((md5($id_client . $type_client . $sharingkey) == $tokenclient) && (md5($id . $sharingkey) == $tokenechantillon)) {
			// die("sui?");
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=AfficheAnalyseEchantillonBack&typeAnalyse=" . $typeAnalyse . "&id=" . $id . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
			//echo $url;
			//die();

			$pdf = file_get_contents($url);

			// header("Content-Type: application/pdf");
			// header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
			// ob_clean();
			// flush();
			// echo $url;
			echo $pdf;
		} else {
			echo "Erreur Token";
		}
	}

	function ExtractionAnalyseDateFront() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$tokenclient = $input->get('tokenclient', '', 'string');
		$id_client = $input->get('id_client', '', 'int');
		$type_client = $input->get('type_client', '', 'int');

		// $date_debut = JRequest::getVar('debut_extraction');
		$date_debut = $input->get('date_debut', '', 'date');
		// var_dump($date_debut);
		// $date_fin = JRequest::getVar('fin_extraction');
		$date_fin = $input->get('date_fin', '', 'date');
		// var_dump($date_fin);
		// die("date");

		$type_extract = $input->get('type_extract', '', 'string');

		global $mainframe;
		$model = new Gbmnetfront();

		$sharingkey = $model->GetSharingKey();

		if (md5($id_client . $type_client . $sharingkey) == $tokenclient) {
			$token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
			$url = $model->GetRemoteToken() . "&task=ExtractionAnalyseDateBack&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&type_extract=" . $type_extract . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";
			//echo $url;
			// die($url);
			$excel = file_get_contents($url);

			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header('Content-Disposition: attachment; filename=extract.xlsx');
			ob_clean();
			flush();
			echo $excel;
		}
	}
}
