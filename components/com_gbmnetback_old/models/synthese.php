<?php
// no direct access
defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');
//CEAPICWorldModel -------------- extends JModel
class Synthese  {
	function AfficheAnalyseEchantillonMATERIAU($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.analyse_materiau, `" . $config->get('db') . "`.mod643_users
				where echantillon_analyse_materiau = " . $echantillon . "
				and type_dossier_analyse_materiau = " . $type_dossier . "
				and validation_analyse_materiau = 1
				and analyse_materiau.valideur_analyse_materiau = mod643_users.id
				order by revision_analyse_materiau desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseEchantillonMEST($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.analyse_mest, `" . $config->get('db') . "`.mod643_users
				where echantillon_analyse_mest = " . $echantillon . "
				and type_dossier_analyse_mest = " . $type_dossier . "
				and validation_analyse_mest = 1
				and analyse_mest.valideur_analyse_mest = mod643_users.id
				order by revision_analyse_mest desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	//cella est utiliser seulement sur StrategieChantierV1 dans la getResultatAndCofrac
	function AfficheAnalyseEchantillonMEST_StratChantierv1($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.analyse_mest
				where echantillon_analyse_mest = " . $echantillon . "
				and type_dossier_analyse_mest = " . $type_dossier . "
				and validation_analyse_mest = 1
				order by revision_analyse_mest desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseEchantillonMETA1($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.analyse_meta_1, `" . $config->get('db') . "`.mod643_users
				where echantillon_analyse_meta_1 = " . $echantillon . "
				and type_dossier_analyse_meta_1 = " . $type_dossier . "
				and validation_analyse_meta_1 = 1
				and analyse_meta_1.valideur_analyse_meta_1 = mod643_users.id
				order by revision_analyse_meta_1 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseEchantillonMETAv0($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.analyse_meta_v0, `" . $config->get('db') . "`.mod643_users
				where echantillon_analyse_meta_v0 = " . $echantillon . "
				and type_dossier_analyse_meta_v0 = " . $type_dossier . "
				and validation_analyse_meta_v0 = 1
				and analyse_meta_v0.valideur_analyse_meta_v0 = mod643_users.id
				order by revision_analyse_meta_v0 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getAnalysesEchantillonMETAv1($echantillon, $type_dossier) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
					*
				FROM 
					{$config->get('GBMNet_db')}.analyse_meta_v1
				JOIN {$config->get('db')}.mod643_users ON mod643_users.id = analyse_meta_v1.id_valideur
				WHERE 
					analyse_meta_v1.id_echantillon = {$echantillon}
					AND analyse_meta_v1.type_dossier = {$type_dossier}
					AND analyse_meta_v1.validation = 1
					AND analyse_meta_v1.id_valideur = mod643_users.id
				ORDER BY 
					analyse_meta_v1.revision DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheDernierePrepaMETAv0($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_meta_v0_prepa
				where analyse_meta_v0_prepa = " . $id_analyse . "
				order by id_analyse_meta_v0_prepa DESC 
				limit 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheOpeRapportMETA269($rapport) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select * from ope_rapport_meta_269
			where rapport_meta_269_ope_rapport_meta_269 = " . $rapport;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$rapport = $db->loadObjectList();
		return $rapport;
	}

	function AfficheAnalyseMateriauExterneEchantillon($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select * from analyse_materiau 
			where echantillon_analyse_materiau  = " . $echantillon . "
			and type_dossier_analyse_materiau  = 2
			order by revision_analyse_materiau  desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$rapport = $db->loadObjectList();
		return $rapport;
	}

	function AfficheFibre($id_fibre) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From type_fibre
				Where id_type_fibre = " . $id_fibre;

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonACR($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_acr, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_acr = " . $id_echantillon . "
				and validation_rapport_acr = 1
				and rapport_acr.valideur_rapport_acr = mod643_users.id
				order by revision_rapport_acr desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMATERIAU($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_materiau, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_materiau = " . $id_echantillon . "
				and validation_rapport_materiau = 1
				and rapport_materiau.valideur_rapport_materiau = mod643_users.id
				order by revision_rapport_materiau desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMEST($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_mest, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_mest = " . $id_echantillon . "
				and validation_rapport_mest = 1
				and rapport_mest.valideur_rapport_mest = mod643_users.id
				order by revision_rapport_mest desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMEST_StratChantierv1($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_mest
				Where echantillon_rapport_mest = " . $id_echantillon . "
				and validation_rapport_mest = 1
				order by revision_rapport_mest desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA11($id_echantillon) {
		$config = JFactory::getConfig();
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_1, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_1 = " . $id_echantillon . "
				and validation_rapport_meta_1 = 1
				and rapport_meta_1.valideur_rapport_meta_1 = mod643_users.id
				order by revision_rapport_meta_1 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA050($id_echantillon) {
		// var_dump($id_echantillon);
		// die();
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_050, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_050 = " . $id_echantillon . "
				and validation_rapport_meta_050 = 1
				and rapport_meta_050.valideur_rapport_meta_050 = mod643_users.id
				order by revision_rapport_meta_050 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA12($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_1_2, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_1_2 = " . $id_echantillon . "
				and validation_rapport_meta_1_2 = 1
				and rapport_meta_1_2.valideur_rapport_meta_1_2 = mod643_users.id
				order by revision_rapport_meta_1_2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA269($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_269, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_269 = " . $id_echantillon . "
				and validation_rapport_meta_269 = 1
				and rapport_meta_269.valideur_rapport_meta_269 = mod643_users.id
				order by revision_rapport_meta_269 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA269v2($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_269_v2, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_269_v2 = " . $id_echantillon . "
				and validation_rapport_meta_269_v2 = 1
				and rapport_meta_269_v2.valideur_rapport_meta_269_v2 = mod643_users.id
				order by revision_rapport_meta_269_v2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA269v3($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_269_v3, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_269_v3 = " . $id_echantillon . "
				and validation_rapport_meta_269_v3 = 1
				and rapport_meta_269_v3.valideur_rapport_meta_269_v3 = mod643_users.id
				order by revision_rapport_meta_269_v3 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonLingettePlomb($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_lingette_plomb, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_lingette_plomb = " . $id_echantillon . "
				and validation_rapport_lingette_plomb = 1
				and rapport_lingette_plomb.valideur_rapport_lingette_plomb = mod643_users.id
				order by revision_rapport_lingette_plomb desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportEchantillonLixiviation($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_lixiviation, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_lixiviation = " . $id_echantillon . "
				and validation_rapport_lixiviation = 1
				and rapport_lixiviation.valideur_rapport_lixiviation = mod643_users.id
				order by revision_rapport_lixiviation desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportEchantillonEcaillePeinture($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_ecaille_peinture, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_ecaille_peinture = " . $id_echantillon . "
				and validation_rapport_ecaille_peinture = 1
				and rapport_ecaille_peinture.valideur_rapport_ecaille_peinture = mod643_users.id
				order by revision_rapport_ecaille_peinture desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportEchantillonAirPlomb($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_air_plomb, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_air_plomb = " . $id_echantillon . "
				and validation_rapport_air_plomb = 1
				and rapport_air_plomb.valideur_rapport_air_plomb = mod643_users.id
				order by revision_rapport_air_plomb desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportEchantillonAirPlombv2($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_air_plomb_v2, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_air_plomb_v2 = " . $id_echantillon . "
				and validation_rapport_air_plomb_v2 = 1
				and rapport_air_plomb_v2.valideur_rapport_air_plomb_v2 = mod643_users.id
				order by revision_rapport_air_plomb_v2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportEchantillonMETA31($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_3, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_3 = " . $id_echantillon . "
				and validation_rapport_meta_3 = 1
				and rapport_meta_3.valideur_rapport_meta_3 = mod643_users.id
				order by revision_rapport_meta_3 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportEchantillonMETA32($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_3_2, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_3_2 = " . $id_echantillon . "
				and validation_rapport_meta_3_2 = 1
				and rapport_meta_3_2.valideur_rapport_meta_3_2 = mod643_users.id
				order by revision_rapport_meta_3_2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheTechnicienLabo($id_technicien_labo) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From technicien_labo
				Where id_technicien_labo = " . $id_technicien_labo;

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$return = $db->loadObjectList();
		return $return[0];
	}

	function AfficheTechnicienPresta($id_presta) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From technicien, presta, mission
				Where id_presta = " . $id_presta . "
				And mission_presta = id_mission
				And technicien_mission = id_technicien";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheTypeBatiment($id_type_batiment) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From type_batiment
				Where id_type_batiment = " . $id_type_batiment;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheUsageLocal($usage_local) {

		$db = JFactory::getDBOGBMNet();
		$query = "Select nom_usage_local
				From usage_local
				Where id_usage_local = '" . $usage_local . "'";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$UsageLocal = $db->loadObjectList();
		return $UsageLocal[0]->nom_usage_local;
	}

	function ListeEchantillonDateValidation($date_debut, $date_fin, $type_presta) {
		$db = JFactory::getDBOGBMNet();

		$query = "Select count(*) as count_echantillon
				from echantillon
				inner join presta ON 
					id_presta = recup_presta_echantillon 
					and date_recup_presta_echantillon between '" . $date_debut . "' and '" . $date_fin . "'
					and type_presta = " . $type_presta . "
				inner join mission ON 
					mission_presta = id_mission
					and client_mission <> 1";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeOperateurMETA269v2($rapport) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select * from operateur_meta_269_v2
			where rapport_operateur_meta_269_v2 = " . $rapport . "
			order by numero_operateur_meta_269_v2 ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$rapport = $db->loadObjectList();
		return $rapport;
	}

	function ListeFiltreMETA269v2($operateur) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select * from filtre_meta_269_v2
			where operateur_filtre_meta_269_v2 = " . $operateur;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$rapport = $db->loadObjectList();
		return $rapport;
	}

	function ListeRapportDateValidation($date_debut, $date_fin, $type_rapport, $analyse, $cofrac) {
		$db = JFactory::getDBOGBMNet();

		$query = "Select count(*) as count_echantillon
				from " . $type_rapport;
		if ($analyse == 1) {
			$query .= ", dossier, echantillon_analyse";
		} else {
			$query .= ", presta, echantillon, mission";
		}

		$query .= "
				where date_validation_" . $type_rapport . " between '" . $date_debut . "' and '" . $date_fin . "'
				and validation_" . $type_rapport . " = 1
				and revision_" . $type_rapport . " = 0 ";

		if ($cofrac == 1)
			$query .= "and cofrac_" . $type_rapport . " = 1 ";

		if ($cofrac == 0)
			$query .= "and cofrac_" . $type_rapport . " = 0 ";

		if ($analyse == 1) {
			$query .= "
			and type_dossier_" . $type_rapport . " = 2
			and echantillon_" . $type_rapport . " = id_echantillon_analyse
			and dossier_echantillon_analyse = id_dossier
			and client_dossier <> 3";
		} else {
			$query .= "
			and echantillon_" . $type_rapport . " = id_echantillon
			and pose_presta_echantillon = id_presta
			and mission_presta = id_mission
			and client_mission <> 1";
		}
		// echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseTypeFibreMateriau($id_analyse, $prepa) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_type_fibre_materiau, type_fibre
				where analyse_type_fibre_materiau = " . $id_analyse . "
				and couche_analyse_type_fibre_materiau = " . $prepa . " 
				and type_fibre_analyse_type_fibre_materiau = id_type_fibre";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonAnalyse($debut, $fin) {
		$date_debut = date("Y-m-d", strtotime($debut)) . " 00:00:00";
		$date_fin = date("Y-m-d", strtotime($fin)) . " 23:59:59";

		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from echantillon_analyse, dossier, client_analyse
				where fiche_analyse_echantillon_analyse = 1
				and dossier_echantillon_analyse = id_dossier
				and date_reception_dossier between '" . $date_debut . "' and '" . $date_fin . "'
				and client_dossier = id_client_analyse";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauDate($debut, $fin) {
		$date_debut = date("Y-m-d", strtotime($debut)) . " 00:00:00";
		$date_fin = date("Y-m-d", strtotime($fin)) . " 23:59:59";
		$config = JFactory::getConfig();

		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.echantillon_analyse, `" . $config->get('GBMNet_db') . "`.dossier, `" . $config->get('GBMNet_db') . "`.client_analyse, `" . $config->get('GBMNet_db') . "`.analyse_materiau, `" . $config->get('db') . "`.mod643_users
				where fiche_analyse_echantillon_analyse = 1
				and dossier_echantillon_analyse = id_dossier
				and date_validation_analyse_materiau between '" . $date_debut . "' and '" . $date_fin . "'
				and echantillon_analyse_materiau = id_echantillon_analyse
				and client_dossier = id_client_analyse
				and valideur_analyse_materiau = mod643_users.id";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMETADate($debut, $fin) {
		$date_debut = date("Y-m-d", strtotime($debut)) . " 00:00:00";
		$date_fin = date("Y-m-d", strtotime($fin)) . " 23:59:59";

		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from `" . $config->get('GBMNet_db') . "`.echantillon_analyse, `" . $config->get('GBMNet_db') . "`.dossier, `" . $config->get('GBMNet_db') . "`.client_analyse, `" . $config->get('GBMNet_db') . "`.analyse_meta_1, `" . $config->get('GBMNet_db') . "`.type_prelevement, `" . $config->get('db') . "`.mod643_users
				where fiche_analyse_echantillon_analyse = 1
				and dossier_echantillon_analyse = id_dossier
				and date_validation_analyse_meta_1 between '" . $date_debut . "' and '" . $date_fin . "'
				and echantillon_analyse_meta_1 = id_echantillon_analyse
				and detail_echantillon_analyse = id_type_prelevement
				and client_dossier = id_client_analyse
				and valideur_analyse_meta_1 = mod643_users.id";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeUsageLocal() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From usage_local";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapport($debut, $fin) {
		$date_debut = date("Y-m-d", strtotime($debut)) . " 00:00:00";
		$date_fin = date("Y-m-d", strtotime($fin)) . " 23:59:59";

		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mission, chantier, client, presta, qualification, detail_type_presta, type_presta, echantillon
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and passage_labo_mission = 0
				and mission_presta = id_mission
				and (pr_presta = 1 or pr_presta = 3)
				and pose_presta_echantillon = id_presta
				and fiche_echantillon = 1
				and detail_type_presta = id_detail_type_presta
				and type_presta_detail_type_presta = id_type_presta
				and qualification_type_presta = id_qualification
				and client_mission = id_client
				and chantier_mission = id_chantier
				
				order by ref_client, client_ref_chantier, date_pose_presta_echantillon, ref_echantillon";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportChantier($chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mission, chantier, client, presta, qualification, detail_type_presta, type_presta, echantillon
				where chantier_mission = " . $chantier . "
				and passage_labo_mission = 0
				and mission_presta = id_mission
				and (pr_presta = 1 or pr_presta = 3)
				and pose_presta_echantillon = id_presta
				and fiche_echantillon = 1
				and detail_type_presta = id_detail_type_presta
				and type_presta_detail_type_presta = id_type_presta
				and qualification_type_presta = id_qualification
				and client_mission = id_client
				and chantier_mission = id_chantier
				order by ref_client, client_ref_chantier, date_pose_presta_echantillon, ref_echantillon";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportTypeFibre($rapport, $couche) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from rapport_type_fibre, type_fibre
				where rapport_type_fibre = " . $rapport . "
				and couche_rapport_type_fibre = " . $couche . "
				and type_fibre_rapport_type_fibre = id_type_fibre
				order by nom_type_fibre";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeTechnicien($technicien) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from technicien
				order by nom_technicien";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	// ========================================================================================================================================
	// ================================ Calcul ================================================================================================
	// ========================================================================================================================================

	function loi_poisson_Ni($Nbr_Fibre) {
		$Nbr_Fibre = str_replace(",", ".", $Nbr_Fibre);
		$Nbr_Fibre = round($Nbr_Fibre, 0);

		switch ($Nbr_Fibre) {
			case 0:
				$result = "0";
				break;
			case 1:
				$result = "0";
				break;
			case 2:
				$result = "0";
				break;
			case 3:
				$result = "0";
				break;
			case 4:
				$result = "1.09";
				break;
			case 5:
				$result = "1.624";
				break;
			case 6:
				$result = "2.202";
				break;
			case 7:
				$result = "2.814";
				break;
			case 8:
				$result = "3.454";
				break;
			case 9:
				$result = "4.115";
				break;
			case 10:
				$result = "4.795";
				break;
			case 11:
				$result = "5.491";
				break;
			case 12:
				$result = "6.201";
				break;
			case 13:
				$result = "6.922";
				break;
			case 14:
				$result = "7.654";
				break;
			case 15:
				$result = "8.396";
				break;
			case 16:
				$result = "9.146";
				break;
			case 17:
				$result = "9.904";
				break;
			case 18:
				$result = "10.668";
				break;
			case 19:
				$result = "11.440";
				break;
			case 20:
				$result = "12.217";
				break;
			case 21:
				$result = "13.000";
				break;
			case 22:
				$result = "13.788";
				break;
			case 23:
				$result = "14.581";
				break;
			case 24:
				$result = "15.378";
				break;
			case 25:
				$result = "16.178";
				break;
			case 26:
				$result = "16.983";
				break;
			case 27:
				$result = "17.793";
				break;
			case 28:
				$result = "18.606";
				break;
			case 29:
				$result = "19.422";
				break;
			case 30:
				$result = "20.241";
				break;
			case 31:
				$result = "21.063";
				break;
			case 32:
				$result = "21.888";
				break;
			case 33:
				$result = "22.715";
				break;
			case 34:
				$result = "23.545";
				break;
			case 35:
				$result = "24.378";
				break;
			case 36:
				$result = "25.213";
				break;
			case 37:
				$result = "26.050";
				break;
			case 38:
				$result = "26.890";
				break;
			case 39:
				$result = "27.732";
				break;
			case 40:
				$result = "28.575";
				break;
			case 41:
				$result = "29.421";
				break;
			case 42:
				$result = "30.269";
				break;
			case 43:
				$result = "31.119";
				break;
			case 44:
				$result = "31.970";
				break;
			case 45:
				$result = "32.823";
				break;
			case 46:
				$result = "33.678";
				break;
			case 47:
				$result = "34.534";
				break;
			case 48:
				$result = "35.392";
				break;
			case 49:
				$result = "36.251";
				break;
			case 50:
				$result = "37.112";
				break;
			case 51:
				$result = "37.973";
				break;
			case 52:
				$result = "38.837";
				break;
			case 53:
				$result = "39.701";
				break;
			case 54:
				$result = "40.567";
				break;
			case 55:
				$result = "41.433";
				break;
			case 56:
				$result = "42.301";
				break;
			case 57:
				$result = "43.171";
				break;
			case 58:
				$result = "44.041";
				break;
			case 59:
				$result = "44.912";
				break;
			case 60:
				$result = "45.785";
				break;
			case 61:
				$result = "46.658";
				break;
			case 62:
				$result = "47.533";
				break;
			case 63:
				$result = "48.409";
				break;
			case 64:
				$result = "49.286";
				break;
			case 65:
				$result = "50.164";
				break;
			case 66:
				$result = "51.042";
				break;
			case 67:
				$result = "51.922";
				break;
			case 68:
				$result = "52.803";
				break;
			case 69:
				$result = "53.685";
				break;
			case 70:
				$result = "54.567";
				break;
			case 71:
				$result = "55.451";
				break;
			case 72:
				$result = "56.335";
				break;
			case 73:
				$result = "57.220";
				break;
			case 74:
				$result = "58.106";
				break;
			case 75:
				$result = "58.993";
				break;
			case 76:
				$result = "59.880";
				break;
			case 77:
				$result = "60.768";
				break;
			case 78:
				$result = "61.657";
				break;
			case 79:
				$result = "62.547";
				break;
			case 80:
				$result = "63.437";
				break;
			case 81:
				$result = "64.328";
				break;
			case 82:
				$result = "65.219";
				break;
			case 83:
				$result = "66.111";
				break;
			case 84:
				$result = "67.003";
				break;
			case 85:
				$result = "67.897";
				break;
			case 86:
				$result = "68.790";
				break;
			case 87:
				$result = "69.684";
				break;
			case 88:
				$result = "70.579";
				break;
			case 89:
				$result = "71.474";
				break;
			case 90:
				$result = "72.370";
				break;
			case 91:
				$result = "73.267";
				break;
			case 92:
				$result = "74.164";
				break;
			case 93:
				$result = "75.061";
				break;
			case 94:
				$result = "75.959";
				break;
			case 95:
				$result = "76.858";
				break;
			case 96:
				$result = "77.757";
				break;
			case 97:
				$result = "78.687";
				break;
			case 98:
				$result = "79.557";
				break;
			case 99:
				$result = "80.458";
				break;
			case 100:
				$result = "81.360";
				break;
			case 110:
				$result = "90.400";
				break;
			case 120:
				$result = "99.490";
				break;
			case 130:
				$result = "108.610";
				break;
		}
		return $result;
	}

	function loi_poisson_Ns($Nbr_Fibre) {
		$Nbr_Fibre = str_replace(",", ".", $Nbr_Fibre);
		// $split = explode(".", $Nbr_Fibre);
		// if ($split[1] = 5)
		// $Nbr_Fibre = $split[0] + 1;
		$Nbr_Fibre = round($Nbr_Fibre, 0);

		switch ($Nbr_Fibre) {
			case 0:
				$result = "2.99";
				break;
			case 1:
				$result = "4.74";
				break;
			case 2:
				$result = "6.20";
				break;
			case 3:
				$result = "7.75";
				break;
			case 4:
				$result = "10.24";
				break;
			case 5:
				$result = "11.67";
				break;
			case 6:
				$result = "13.06";
				break;
			case 7:
				$result = "14.42";
				break;
			case 8:
				$result = "15.76";
				break;
			case 9:
				$result = "17.09";
				break;
			case 10:
				$result = "18.39";
				break;
			case 11:
				$result = "19.68";
				break;
			case 12:
				$result = "20.96";
				break;
			case 13:
				$result = "22.23";
				break;
			case 14:
				$result = "23.49";
				break;
			case 15:
				$result = "24.74";
				break;
			case 16:
				$result = "25.98";
				break;
			case 17:
				$result = "27.22";
				break;
			case 18:
				$result = "28.45";
				break;
			case 19:
				$result = "29.67";
				break;
			case 20:
				$result = "30.89";
				break;
			case 21:
				$result = "32.10";
				break;
			case 22:
				$result = "33.31";
				break;
			case 23:
				$result = "34.51";
				break;
			case 24:
				$result = "35.71";
				break;
			case 25:
				$result = "36.91";
				break;
			case 26:
				$result = "38.10";
				break;
			case 27:
				$result = "39.28";
				break;
			case 28:
				$result = "40.47";
				break;
			case 29:
				$result = "41.65";
				break;
			case 30:
				$result = "42.83";
				break;
			case 31:
				$result = "44.00";
				break;
			case 32:
				$result = "45.18";
				break;
			case 33:
				$result = "46.35";
				break;
			case 34:
				$result = "47.51";
				break;
			case 35:
				$result = "48.68";
				break;
			case 36:
				$result = "49.84";
				break;
			case 37:
				$result = "51.00";
				break;
			case 38:
				$result = "52.16";
				break;
			case 39:
				$result = "53.32";
				break;
			case 40:
				$result = "54.47";
				break;
			case 41:
				$result = "55.62";
				break;
			case 42:
				$result = "56.77";
				break;
			case 43:
				$result = "57.92";
				break;
			case 44:
				$result = "59.07";
				break;
			case 45:
				$result = "60.21";
				break;
			case 46:
				$result = "61.36";
				break;
			case 47:
				$result = "62.50";
				break;
			case 48:
				$result = "63.64";
				break;
			case 49:
				$result = "64.78";
				break;
			case 50:
				$result = "65.92";
				break;
			case 51:
				$result = "67.06";
				break;
			case 52:
				$result = "68.19";
				break;
			case 53:
				$result = "69.33";
				break;
			case 54:
				$result = "70.46";
				break;
			case 55:
				$result = "71.59";
				break;
			case 56:
				$result = "72.72";
				break;
			case 57:
				$result = "73.85";
				break;
			case 58:
				$result = "74.98";
				break;
			case 59:
				$result = "76.11";
				break;
			case 60:
				$result = "77.23";
				break;
			case 61:
				$result = "78.36";
				break;
			case 62:
				$result = "79.48";
				break;
			case 63:
				$result = "80.61";
				break;
			case 64:
				$result = "81.73";
				break;
			case 65:
				$result = "82.85";
				break;
			case 66:
				$result = "83.97";
				break;
			case 67:
				$result = "85.09";
				break;
			case 68:
				$result = "86.21";
				break;
			case 69:
				$result = "87.32";
				break;
			case 70:
				$result = "88.44";
				break;
			case 71:
				$result = "89.56";
				break;
			case 72:
				$result = "90.67";
				break;
			case 73:
				$result = "91.79";
				break;
			case 74:
				$result = "92.90";
				break;
			case 75:
				$result = "94.01";
				break;
			case 76:
				$result = "95.13";
				break;
			case 77:
				$result = "96.24";
				break;
			case 78:
				$result = "97.35";
				break;
			case 79:
				$result = "98.46";
				break;
			case 80:
				$result = "99.57";
				break;
			case 81:
				$result = "100.68";
				break;
			case 82:
				$result = "101.79";
				break;
			case 83:
				$result = "102.90";
				break;
			case 84:
				$result = "104.00";
				break;
			case 85:
				$result = "105.11";
				break;
			case 86:
				$result = "106.21";
				break;
			case 87:
				$result = "107.32";
				break;
			case 88:
				$result = "108.42";
				break;
			case 89:
				$result = "109.53";
				break;
			case 90:
				$result = "110.63";
				break;
			case 91:
				$result = "111.73";
				break;
			case 92:
				$result = "112.83";
				break;
			case 93:
				$result = "113.94";
				break;
			case 94:
				$result = "115.04";
				break;
			case 95:
				$result = "116.14";
				break;
			case 96:
				$result = "117.24";
				break;
			case 97:
				$result = "118.34";
				break;
			case 98:
				$result = "119.44";
				break;
			case 99:
				$result = "120.53";
				break;
			case 100:
				$result = "124.66";
				break;
			case 110:
				$result = "132.61";
				break;
			case 120:
				$result = "143.52";
				break;
			case 130:
				$result = "154.39";
				break;
		}
		return $result;
	}

	function calcul_sa($Nbr_Carres, $SG, $SF, $Volume, $Fraction_Filtre) {
		$result = 1 / $Nbr_Carres / $SG * $SF / ($Volume * $Fraction_Filtre);
		return $result;
	}

	function calcul_sa_mm($Nbr_Carres, $SG) {
		$result = 1 / ($Nbr_Carres * $SG);
		return $result;
	}

	function calcul_sa_litre($Nbr_Carres, $SG, $SF, $Volume, $Fraction_Filtre) {
		$result = $SF / ($Nbr_Carres * $SG * $Volume * $Fraction_Filtre);
		return $result;
	}

	function concentration_moyenne(
		$Nbr_Carres,
		$Nbr_Fibre,
		$Volume,
		$Fraction_Filtre,
		$Diametre_Filtre,
		$Incertitude,
		$Loi_Poisson_Ns,
		$SF,
		$SG,
		$ED,
		$EPC,
		$ELPC,
		$D,
		$CC,
		$ECC,
		$EMIC,
		$ELMIC
	) {
		if ($Nbr_Fibre > 3) {

			$result = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * $Volume * $Fraction_Filtre);

			return $result;
		} else {

			$C = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * $Fraction_Filtre * $Volume);
			$F1 = pow((($Loi_Poisson_Ns - $Nbr_Fibre) / (2 * $Nbr_Fibre)), 2);
			$F2 = pow((($Incertitude) / (100 * 2)), 2);
			$F3 = pow((0.024), 2);
			$Csup = $C + ((2 * $C) * (SQRT($F1 + $F2 + $F3)));

			return $Csup;
		}
	}

	function concentration_minimum(
		$Nbr_Carres,
		$Nbr_Fibre,
		$Volume,
		$Fraction_Filtre,
		$Diametre_Filtre,
		$Incertitude,
		$Loi_Poisson_Ni,
		$SF,
		$SG,
		$ED,
		$EPC,
		$ELPC,
		$D,
		$CC,
		$ECC,
		$EMIC,
		$ELMIC
	) {

		if ($Nbr_Fibre > 3) {

			$C = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * $Fraction_Filtre * $Volume);
			$F1 = pow((($Nbr_Fibre - $Loi_Poisson_Ni) / (2 * $Nbr_Fibre)), 2);
			$F2 = pow(($Incertitude / (100 * 2)), 2);
			$F3 = pow((0.024), 2);
			$Cinf = $C - ((2 * $C) * (SQRT($F1 + $F2 + $F3)));

			$result = $Cinf;
			return $result;
		} else {
			$result = "/";
			return $result;
		}
	}

	function concentration_maximum(
		$Nbr_Carres,
		$Nbr_Fibre,
		$Volume,
		$Fraction_Filtre,
		$Diametre_Filtre,
		$Incertitude,
		$Loi_Poisson_Ns,
		$SF,
		$SG,
		$ED,
		$EPC,
		$ELPC,
		$D,
		$CC,
		$ECC,
		$EMIC,
		$ELMIC
	) {
		if ($Nbr_Fibre == 0) {
			$Cs = ($Loi_Poisson_Ns * $SF) / ($Nbr_Carres * $SG * $Fraction_Filtre * $Volume);
			$F1 = pow(($Incertitude / (100 * 2)), 2);
			$F2 = pow((0.024), 2);
			$Csup = $Cs + ((2 * $Cs) * (SQRT($F1 + $F2)));
		} else {
			$C = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * $Fraction_Filtre * $Volume);
			$F1 = pow((($Loi_Poisson_Ns - $Nbr_Fibre) / (2 * $Nbr_Fibre)), 2);
			$F2 = pow((($Incertitude) / (100 * 2)), 2);
			$F3 = pow((0.024), 2);
			$Csup = $C + ((2 * $C) * (SQRT($F1 + $F2 + $F3)));
		}

		$result = $Csup;
		return $result;
	}

	function concentration_normalisee($Nbr_Fibre, $Nbr_Carres, $SG, $SF, $Volume, $Fraction_Filtre) {
		$Cs = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * $Volume * $Fraction_Filtre);
		return $Cs;
	}
}
