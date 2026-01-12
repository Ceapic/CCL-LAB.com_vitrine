<?php
// no direct access
defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');
// echo "management";
// die();
class Management{

	function AfficheAnalyseEchantillonMETA1($echantillon, $type_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_meta_1
				where echantillon_analyse_meta_1 = " . $echantillon . "
				and type_dossier_analyse_meta_1 = " . $type_dossier . "
				and validation_analyse_meta_1 = 1
				order by revision_analyse_meta_1 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseEchantillonMETAv0($echantillon, $type_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_meta_v0, dossier, echantillon
				where echantillon_analyse_meta_v0 = " . $echantillon . "
				and type_dossier_analyse_meta_v0 = " . $type_dossier . "
				and type_dossier_analyse_meta_v0 = 1
				and validation_analyse_meta_v0 = 1
				and echantillon_analyse_meta_v0 = id_echantillon
				and dossier_echantillon = id_dossier
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
		$query = "SELECT *
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

	function AfficheAnalyseEchantillonMEST($echantillon, $type_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_mest
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

	function AfficheAnalyseEchantillonMATERIAU($echantillon, $type_dossier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_materiau
				where echantillon_analyse_materiau = " . $echantillon . "
				and type_dossier_analyse_materiau = " . $type_dossier . "
				and validation_analyse_materiau = 1
				order by revision_analyse_materiau desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapport($id_echantillon, $type_rapport) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`." . $type_rapport . ", `" . $config->get('db') . "`.mod643_users
				Where echantillon_" . $type_rapport . " = " . $id_echantillon . "
				and validation_" . $type_rapport . " = 1
				and " . $type_rapport . ".valideur_" . $type_rapport . " = mod643_users.id
				order by revision_" . $type_rapport . "";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportMateriau($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_materiau, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_materiau = " . $id_echantillon . "
				and validation_rapport_materiau = 1
				and rapport_materiau.valideur_rapport_materiau = mod643_users.id
				order by revision_rapport_materiau";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportMEST($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_mest, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_mest = " . $id_echantillon . "
				and validation_rapport_mest = 1
				and rapport_mest.valideur_rapport_mest = mod643_users.id
				order by revision_rapport_mest";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportACR($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_acr, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_acr = " . $id_echantillon . "
				and validation_rapport_acr = 1
				and rapport_acr.valideur_rapport_acr = mod643_users.id
				order by revision_rapport_acr";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportLingettePlomb($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_lingette_plomb, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_lingette_plomb = " . $id_echantillon . "
				and validation_rapport_lingette_plomb = 1
				and rapport_lingette_plomb.valideur_rapport_lingette_plomb = mod643_users.id
				order by revision_rapport_lingette_plomb";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportMETA1($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_1, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_1 = " . $id_echantillon . "
				and validation_rapport_meta_1 = 1
				and rapport_meta_1.valideur_rapport_meta_1 = mod643_users.id
				order by revision_rapport_meta_1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportMETA12($id_echantillon) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From `" . $config->get('GBMNet_db') . "`.rapport_meta_1_2, `" . $config->get('db') . "`.mod643_users
				Where echantillon_rapport_meta_1_2 = " . $id_echantillon . "
				and validation_rapport_meta_1_2 = 1
				and rapport_meta_1_2.valideur_rapport_meta_1_2 = mod643_users.id
				order by revision_rapport_meta_1_2";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$presta = $db->loadObjectList();
		return $presta;
	}

	function AfficheRapportMETA050($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from rapport_meta_050
				where echantillon_rapport_meta_050 = " . $echantillon . "
				and validation_rapport_meta_050 = 1
				order by revision_rapport_meta_050 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportMETA269($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from rapport_meta_269
				where echantillon_rapport_meta_269 = " . $echantillon . "
				and validation_rapport_meta_269 = 1
				order by revision_rapport_meta_269 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportMETA269V2($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from rapport_meta_269_v2
				where echantillon_rapport_meta_269_v2 = " . $echantillon . "
				and validation_rapport_meta_269_v2 = 1
				order by revision_rapport_meta_269_v2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeOperateurMETA269V2($id_rapport) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from operateur_meta_269_v2
				where rapport_operateur_meta_269_v2 = " . $id_rapport;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeFiltreMETA269V2($id_operateur) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from filtre_meta_269_v2
				where operateur_filtre_meta_269_v2 = " . $id_operateur;
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

	function ListePrepaMETAv0($id_analyse) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from analyse_meta_v0_prepa
				where analyse_meta_v0_prepa = " . $id_analyse . "
				order by ordre_analyse_meta_v0_prepa ASC";
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

	function AfficheTechnicien($technicien) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from technicien
				where id_technicien = " . $technicien;
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

	function ListeEchantillonTechnicienDate2($technicien, $date_debut, $date_fin) {
		$db = JFactory::getDBOGBMNet();
		$query = "				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*, 
					'' as resultat_concentration, '' as signe_resultat, 
					'' as materiaux_concerne, '' as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr,
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250,
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'META050' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_050 ON echantillon_rapport_meta_050 = id_echantillon
			
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				and revision_rapport_meta_050 = 0
				and validation_rapport_meta_050 = 1
				
				UNION
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*,
					'' as resultat_concentration, '' as signe_resultat, 
					'' as materiaux_concerne, '' as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr, 
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250, 
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'META269V2' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_269_v2 ON echantillon_rapport_meta_269_v2 = id_echantillon
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				and revision_rapport_meta_269_v2 = 0
				and validation_rapport_meta_269_v2 = 1
				
				order by date_mission ASC, type_presta ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonTechnicienDate($technicien, $date_debut, $date_fin) {
		$db = JFactory::getDBOGBMNet();
		$query = "				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*, 
					resultat_concentration_rapport_meta_1 as resultat_concentration, signe_resultat_concentration_rapport_meta_1 as signe_resultat, 
					materiaux_concerne_rapport_meta_1 as materiaux_concerne, duree_rapport_meta_1 as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr,
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250,
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					nb_fibre_rapport_meta_1 as nb_fibre,
					'META1' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_1 ON echantillon_rapport_meta_1 = id_echantillon
				INNER JOIN (select p2.echantillon_rapport_meta_1, max(p2.revision_rapport_meta_1) as last_revision from rapport_meta_1 p2 where validation_rapport_meta_1 = 1 group by p2.echantillon_rapport_meta_1) temp_rapport 
					ON temp_rapport.echantillon_rapport_meta_1 =  rapport_meta_1.echantillon_rapport_meta_1 AND temp_rapport.last_revision = rapport_meta_1.revision_rapport_meta_1

				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				
				UNION
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*, 
					'' as resultat_concentration, '' as signe_resultat, 
					'' as materiaux_concerne, '' as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr,
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250,
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'META050' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_050 ON echantillon_rapport_meta_050 = id_echantillon
			
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				and revision_rapport_meta_050 = 0
				and validation_rapport_meta_050 = 1
				
				UNION
				
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*,
					empoussierement_rapport_meta_1_2 as resultat_concentration, signe_empoussierement_rapport_meta_1_2 as signe_resultat, 
					materiau_rapport_meta_1_2 as materiaux_concerne, duree_essai_rapport_meta_1_2 as duree,
					type_protection_respiratoire_rapport_meta_1_2 as type_protection, facteur_protection_respiratoire_rapport_meta_1_2 as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr, 
					'' as facteur_protection_10, 	'' as facteur_protection_60, '' as facteur_protection_250,
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					nb_fibre_rapport_meta_1_2 as nb_fibre,
					'META12' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_1_2 ON echantillon_rapport_meta_1_2 = id_echantillon
				INNER JOIN (select p2.echantillon_rapport_meta_1_2, max(p2.revision_rapport_meta_1_2) as last_revision from rapport_meta_1_2 p2 where validation_rapport_meta_1_2 = 1 group by p2.echantillon_rapport_meta_1_2) temp_rapport 
					ON temp_rapport.echantillon_rapport_meta_1_2 =  rapport_meta_1_2.echantillon_rapport_meta_1_2 AND temp_rapport.last_revision = rapport_meta_1_2.revision_rapport_meta_1_2

				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				
				UNION
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*,
					'' as resultat_concentration, '' as signe_resultat, 
					materiau_rapport_meta_269 as materiaux_concerne, duree_essai_rapport_meta_269 as duree, 
					'' as type_protection, '' as facteur_protection,
					ffp3_apr_op1_ope_rapport_meta_269 as ffp3_apr, va_apr_op1_ope_rapport_meta_269 as va_apr, ad_apr_op1_ope_rapport_meta_269 as ad_apr, 
					facteur_10_op1_ope_rapport_meta_269 as facteur_protection_10, facteur_60_op1_ope_rapport_meta_269 as facteur_protection_60, facteur_250_op1_ope_rapport_meta_269 as facteur_protection_250, 
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'META269' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_269 ON echantillon_rapport_meta_269 = id_echantillon
				INNER JOIN (select p2.echantillon_rapport_meta_269, max(p2.revision_rapport_meta_269) as last_revision from rapport_meta_269 p2 where validation_rapport_meta_269 = 1 group by p2.echantillon_rapport_meta_269) temp_rapport 
					ON temp_rapport.echantillon_rapport_meta_269 =  rapport_meta_269.echantillon_rapport_meta_269 AND temp_rapport.last_revision = rapport_meta_269.revision_rapport_meta_269
				INNER JOIN ope_rapport_meta_269 ON rapport_meta_269_ope_rapport_meta_269 = id_rapport_meta_269
				
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				
				UNION
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*,
					'' as resultat_concentration, '' as signe_resultat, 
					'' as materiaux_concerne, '' as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr, 
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250, 
					'' as resultat_analyse_1_rapport_materiau, '' as resultat_analyse_2_rapport_materiau, '' as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'META269V2' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_meta_269_v2 ON echantillon_rapport_meta_269_v2 = id_echantillon
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				and revision_rapport_meta_269_v2 = 0
				and validation_rapport_meta_269_v2 = 1
				
				UNION
				
				Select mission.*, presta.*, echantillon.*, chantier.*, detail_type_presta.*,
					'' as resultat_concentration, '' as signe_resultat, 
					type_materiau_rapport_materiau as materiaux_concerne, '5 min' as duree, 
					'' as type_protection, '' as facteur_protection,
					'' as ffp3_apr, '' as va_apr, '' as ad_apr, 
					'' as facteur_protection_10, '' as facteur_protection_60, '' as facteur_protection_250,
					resultat_analyse_1_rapport_materiau as resultat_analyse_1_rapport_materiau, resultat_analyse_2_rapport_materiau as resultat_analyse_2_rapport_materiau, resultat_analyse_3_rapport_materiau as resultat_analyse_3_rapport_materiau,
					'' as nb_fibre,
					'MATERIAU' as type_rapport
				from mission
				INNER JOIN presta ON mission_presta = id_mission
				INNER JOIN echantillon ON (pose_presta_echantillon = id_presta OR recup_presta_echantillon = id_presta)
				INNER JOIN chantier ON id_chantier = chantier_mission
				INNER JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				INNER JOIN rapport_materiau ON echantillon_rapport_materiau = id_echantillon
				INNER JOIN (select p2.echantillon_rapport_materiau, max(p2.revision_rapport_materiau) as last_revision from rapport_materiau p2 where validation_rapport_materiau = 1 group by p2.echantillon_rapport_materiau) temp_rapport 
					ON temp_rapport.echantillon_rapport_materiau =  rapport_materiau.echantillon_rapport_materiau AND temp_rapport.last_revision = rapport_materiau.revision_rapport_materiau
				
				where date_mission between '" . $date_debut . "' and '" . $date_fin . "'
				and technicien_mission = " . $technicien . "
				and auteur_prelevement_rapport_materiau = 'CEAPIC'
				
				order by date_mission ASC, type_presta ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonDate($id_client, $id_chantier, $date_debut, $date_fin) {
		// die("salutbonjour");
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT echantillon.*, ref_client_chantier, nom_chantier, adresse_chantier, cp_chantier, ville_chantier, nom_qualification, affichage_rapport_detail_type_presta
				FROM echantillon
				JOIN presta ON id_presta = pose_presta_echantillon
				JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
				JOIN type_presta ON id_type_presta = type_presta_detail_type_presta
				JOIN qualification ON id_qualification = qualification_type_presta
				JOIN mission ON id_mission = mission_presta
				JOIN client ON id_client = client_mission
				JOIN chantier ON id_chantier = chantier_mission
				WHERE client_mission = " . $id_client;
		if ($id_chantier == "0")
			$query .= " AND date_pose_presta_echantillon between '" . $date_debut . "' and '" . $date_fin . "'";
		if ($id_chantier <> "0")
			$query .= " AND chantier_mission = " . $id_chantier . " ";

		$query .= " order by date_pose_presta_echantillon ASC, ref_echantillon ASC";
		// echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeFactureBilan() {
		$db = JFactory::getDBOGBMNet();
		$query = "			
			SELECT ref_client, nom_client, id_facture, ref_facture, date_creation_facture, date_debut_facture, date_reglement_facture, montant_reglement_facture, reglement_facture,
				YEAR(date_debut_facture) as YEAR, MONTH(date_debut_facture) as MONTH,
				SUM(total_prestation) as total_prestation,
				supplement, 
				regularisation
			FROM facture
			INNER JOIN (
				SELECT facture_grille_facture, 
					SUM(`analyse_grille_facture`) + SUM(`deplacement_grille_facture`) as total_prestation
				FROM grille_facture
				Group by facture_grille_facture
			) AS grille_facture ON facture_grille_facture = id_facture
			INNER JOIN client ON id_client = client_facture
			LEFT JOIN (
				SELECT facture_grille_divers_facture, 
					SUM(IF(regularisation_grille_divers_facture = 0, montant_grille_divers_facture, 0)) as supplement, 
					SUM(IF(regularisation_grille_divers_facture = 1, montant_grille_divers_facture, 0)) as regularisation
				FROM grille_divers_facture
				Group by facture_grille_divers_facture
			) AS grille_divers_facture ON facture_grille_divers_facture = id_facture
			WHERE validation_facture = 1
			and disable_facture = 0
			group by YEAR(date_debut_facture), MONTH(date_debut_facture), id_facture
			order by YEAR(date_debut_facture) DESC, MONTH(date_debut_facture) DESC, date_creation_facture DESC";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function CAMensuelClient($id_client) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT YEAR(date_debut_facture) as YEAR, MONTH(date_debut_facture) as MONTH,
				SUM(total_prestation) as total_prestation,
				supplement, 
				regularisation
			FROM facture
			INNER JOIN (
				SELECT facture_grille_facture, 
					SUM(`analyse_grille_facture`) + SUM(`deplacement_grille_facture`) as total_prestation
				FROM grille_facture
				Group by facture_grille_facture
			) AS grille_facture ON facture_grille_facture = id_facture
			INNER JOIN client ON id_client = client_facture
			LEFT JOIN (
				SELECT facture_grille_divers_facture, 
					SUM(IF(regularisation_grille_divers_facture = 0, montant_grille_divers_facture, 0)) as supplement, 
					SUM(IF(regularisation_grille_divers_facture = 1, montant_grille_divers_facture, 0)) as regularisation
				FROM grille_divers_facture
				Group by facture_grille_divers_facture
			) AS grille_divers_facture ON facture_grille_divers_facture = id_facture
			WHERE client_facture = " . $id_client . "
			and validation_facture = 1
			and disable_facture = 0
			group by YEAR(date_debut_facture), MONTH(date_debut_facture)
			order by YEAR(date_debut_facture), MONTH(date_debut_facture)";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function CAMensuel($ANNEE) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT YEAR(date_debut_facture) as YEAR, MONTH(date_debut_facture) as MONTH,
				SUM(total_prestation) as total_prestation,
				SUM(supplement) as supplement, 
				SUM(regularisation) as regularisation
			FROM facture
			INNER JOIN (
				SELECT facture_grille_facture, 
					SUM(`analyse_grille_facture`) + SUM(`deplacement_grille_facture`) as total_prestation
				FROM grille_facture
				Group by facture_grille_facture
			) AS grille_facture ON facture_grille_facture = id_facture
			INNER JOIN client ON id_client = client_facture
			LEFT JOIN (
				SELECT facture_grille_divers_facture, 
					SUM(IF(regularisation_grille_divers_facture = 0, montant_grille_divers_facture, 0)) as supplement, 
					SUM(IF(regularisation_grille_divers_facture = 1, montant_grille_divers_facture, 0)) as regularisation
				FROM grille_divers_facture
				Group by facture_grille_divers_facture
			) AS grille_divers_facture ON facture_grille_divers_facture = id_facture
			WHERE validation_facture = 1
			and disable_facture = 0
			and YEAR(date_debut_facture) = " . $ANNEE . "
			group by YEAR(date_debut_facture), MONTH(date_debut_facture)
			order by YEAR(date_debut_facture), MONTH(date_debut_facture)";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeObjectif() {
		$db = JFactory::getDBOGBMNet();
		$query = "			
			SELECT ref_client, nom_client, id_facture, ref_facture, date_creation_facture, date_debut_facture, date_reglement_facture, montant_reglement_facture, reglement_facture,
				YEAR(date_debut_facture) as YEAR, MONTH(date_debut_facture) as MONTH,
				SUM(total_prestation) as total_prestation,
				supplement, 
				regularisation
			FROM facture
			INNER JOIN (
				SELECT facture_grille_facture, 
					SUM(`analyse_grille_facture`) + SUM(`deplacement_grille_facture`) as total_prestation
				FROM grille_facture
				Group by facture_grille_facture
			) AS grille_facture ON facture_grille_facture = id_facture
			INNER JOIN client ON id_client = client_facture
			LEFT JOIN (
				SELECT facture_grille_divers_facture, 
					SUM(IF(regularisation_grille_divers_facture = 0, montant_grille_divers_facture, 0)) as supplement, 
					SUM(IF(regularisation_grille_divers_facture = 1, montant_grille_divers_facture, 0)) as regularisation
				FROM grille_divers_facture
				Group by facture_grille_divers_facture
			) AS grille_divers_facture ON facture_grille_divers_facture = id_facture
			WHERE validation_facture = 1
			and disable_facture = 0
			group by YEAR(date_debut_facture), MONTH(date_debut_facture), id_facture
			order by YEAR(date_debut_facture) DESC, MONTH(date_debut_facture) DESC, date_creation_facture DESC";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ModifierFactureBilan($id_facture, $date_reglement_facture, $reglement_facture, $montant_reglement_facture) {
		$data = new stdClass();
		$data->id_facture = $id_facture;
		$data->date_reglement_facture = date('Y-m-d', strtotime($date_reglement_facture));
		$data->reglement_facture = $reglement_facture;
		$data->montant_reglement_facture = $montant_reglement_facture;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('facture', $data, 'id_facture');


		$query = "Select *
				from facture
				where id_facture=" . $id_facture;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ModifierObjectifChiffreAffaire($annee_objectif_chiffre_affaire, $mois_objectif_chiffre_affaire, $valeur_objectif_chiffre_affaire, $type_objectif_chiffre_affaire) {
		$db = JFactory::getDBOGBMNet();
		$query = "delete from objectif_chiffre_affaire
				where annee_objectif_chiffre_affaire=" . $annee_objectif_chiffre_affaire . "
				and mois_objectif_chiffre_affaire=" . $mois_objectif_chiffre_affaire . "
				and type_objectif_chiffre_affaire=" . $type_objectif_chiffre_affaire;
		$db->setQuery($query);
		$result = $db->execute();

		$query = "INSERT INTO objectif_chiffre_affaire 
			(annee_objectif_chiffre_affaire, mois_objectif_chiffre_affaire, valeur_objectif_chiffre_affaire, type_objectif_chiffre_affaire)
			VALUES ('" . $annee_objectif_chiffre_affaire . "', '" . $mois_objectif_chiffre_affaire . "', '" . $valeur_objectif_chiffre_affaire . "', '" . $type_objectif_chiffre_affaire . "');";
		$db->setQuery($query);
		$result = $db->execute();
	}

	function ListeObjectifAnnee($annee_objectif_chiffre_affaire, $type_objectif_chiffre_affaire) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from objectif_chiffre_affaire
				where annee_objectif_chiffre_affaire=" . $annee_objectif_chiffre_affaire . "
				and type_objectif_chiffre_affaire = " . $type_objectif_chiffre_affaire . "
				order by annee_objectif_chiffre_affaire, mois_objectif_chiffre_affaire";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function calcul_sa($Nbr_Carres, $SG, $SF, $Volume, $Fraction_Filtre) {
		$result = 1 / $Nbr_Carres / $SG * $SF / ($Volume * $Fraction_Filtre);
		return $result;
	}

	function concentration_normalisee($Nbr_Fibre, $Nbr_Carres, $SG, $SF, $Volume, $Fraction_Filtre) {
		$result = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * ($Volume * $Fraction_Filtre));
		return $result;
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

		$K15 = $Loi_Poisson_Ns;

		$S15 = ($K15 * $SF) / ($Nbr_Carres * $SG * ($Volume * $Fraction_Filtre));

		$D10 = $Diametre_Filtre;

		$V10 = ($D10 / 2) * 2;

		$W10 = (22 / 7) * pow($D10 / 2, 2);

		$X10 = 2 * (pow(($V10 / SQRT(3)), 2) / pow($W10, 2));

		$Y10 = pow($D, 2);

		$Z10 = pow($ED, 2);

		$AA10 = pow($EPC / SQRT(3), 2);

		$AB10 = pow($ELPC * 2 / SQRT(3), 2);

		$AC10 = 2 * (($Z10 + $AA10 + $AB10) / $Y10);

		$AD10 = pow($CC, 2);

		$AE10 = pow($ECC, 2);

		$AF10 = pow($EMIC / SQRT(3), 2);

		$AG10 = pow($ELMIC / SQRT(3), 2);

		$AH10 = 2 * (($AE10 + $AF10 + $AG10) / $AD10);

		$AI15 = pow(($X10 + $AC10 + $AH10) + ($Incertitude / 100), 2);

		$M15 = ($Nbr_Fibre * $SF) / ($Nbr_Carres * $SG * ($Volume * $Fraction_Filtre));

		$AJ15 = $AI15 * pow($M15, 2);

		$AL15 = ($S15 + 2 * SQRT($AJ15)) + 0.05;

		$result = $AL15;
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

	function calcul_sa_filtre($surface_filtration, $nbr_carres, $surface_grille, $fraction_filtre, $total_filtre) {
		$result = $surface_filtration / ($nbr_carres * $surface_grille * $fraction_filtre * $total_filtre);
		return $result;
	}

	function calcul_densite($nbr_fibre, $surface_filtration, $nbr_carres, $surface_grille, $fraction_filtre, $total_filtre) {
		$result = ($nbr_fibre * $surface_filtration) / ($nbr_carres * $surface_grille * $fraction_filtre * $total_filtre);
		return $result;
	}

	function calcul_densite_inferieur($nbr_fibre, $surface_filtration, $nbr_carres, $surface_grille, $fraction_filtre, $Loi_Poisson_Ni, $total_filtre) {
		if ($nbr_fibre < 4) {
			$result = "/";
			return $result;
		} else {
			$D = ($nbr_fibre * $surface_filtration) / ($nbr_carres * $surface_grille * $fraction_filtre * $total_filtre);
			$F1 = pow((($nbr_fibre - $Loi_Poisson_Ni) / (2 * $nbr_fibre)), 2);
			$F2 = pow((0.024), 2);
			$Dinf = $D - ((2 * $D) * (SQRT($F1 + $F2)));
			$result = $Dinf;
			return $result;
		}
	}

	function calcul_densite_superieur($nbr_fibre, $surface_filtration, $nbr_carres, $surface_grille, $fraction_filtre, $Loi_Poisson_Ns, $total_filtre) {
		if ($nbr_fibre == 0) {
			$Ds = (2.99 * $surface_filtration) / ($nbr_carres * $surface_grille * $fraction_filtre * $total_filtre);
			$F1 = pow((0.024), 2);
			$Dsup = $Ds + ((2 * $Ds) * SQRT($F1));
		} else {
			$D = ($nbr_fibre * $surface_filtration) / ($nbr_carres * $surface_grille * $fraction_filtre * $total_filtre);
			$F1 = pow((($Loi_Poisson_Ns - $nbr_fibre) / (2 * $nbr_fibre)), 2);
			$F2 = pow((0.024), 2);
			$Dsup = $D + ((2 * $D) * (SQRT($F1 + $F2)));
		}

		$result = $Dsup;
		return $result;
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
}
