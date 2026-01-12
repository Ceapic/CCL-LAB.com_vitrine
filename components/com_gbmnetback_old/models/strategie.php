<?php
// no direct access
defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');
//CEAPICWorldModel -------------- extends JModel 
class Strategie  {
	function AfficheChantierEchantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*
				from echantillon, presta, mission, chantier, client
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheEchantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and client_mission = id_client
				and chantier_mission = id_chantier";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheLastStrategieChantier($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from strategie_chantier, echantillon
				where echantillon_strategie_chantier = " . $id_echantillon . "
				and id_echantillon = echantillon_strategie_chantier
				and validation_strategie_chantier = 1
				order by revision_strategie_chantier desc
				Limit 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	static function getStrategieChantierV1FromEchantillon($idEchantillon) {
		$db = JFactory::getDBOGBMNet();
		$req = "SELECT 
            strat.*
        FROM
            strategie_chantier_v1 strat 
        JOIN (
            SELECT 
                MAX(id) as id
            FROM 
                strategie_chantier_v1
            WHERE 
                validation = 1
            GROUP BY 
                id_echantillon
        ) LAST_STRAT ON LAST_STRAT.id = strat.id
        
        WHERE
            strat.id_echantillon = " . $idEchantillon;

		$db->setQuery($req);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObject();
	}

	function AfficheMesureStrategie($id_mesure_strategie) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mesure_strategie, contexte_mesure_strategie
				where id_mesure_strategie = " . $id_mesure_strategie . "
				and contexte_mesure_strategie = id_contexte_mesure_strategie";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportFinal($id_rapport_final) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select rapport_final.*, id_client, id_chantier, id_echantillon
				from rapport_final, echantillon, presta, mission, client, chantier
				where id_rapport_final = " . $id_rapport_final . "
				and echantillon_rapport_final = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheStrategieChantier($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from strategie_chantier
				where id_strategie_chantier = " . $id_strategie_chantier;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheTypeMesureZoneTravailRow($id_zone_travail_multi) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select nom_pdf_contexte_mesure_strategie
				from mesure_strategie, contexte_mesure_strategie, zone_travail_multi_row
				where zone_travail_multi_row = " . $id_zone_travail_multi . "
				and type_mesure_zone_travail_multi_row = id_mesure_strategie
				and contexte_mesure_strategie = id_contexte_mesure_strategie
				group by nom_pdf_contexte_mesure_strategie
				order by id_contexte_mesure_strategie";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheUserJoomla($id_user) {
		$db	= $this->getDbo();
		$query = "Select name
				from jml_users
				where id = " . $id_user;

		$db->setQuery($query);
		// Get the user id based on the token.
		// echo $db->setQuery(
		// 'SELECT '.$db->quoteName('name').' FROM '.$db->quoteName('#__users') .
		// ' WHERE '.$db->quoteName('id').' = '.$db->Quote($id_user) .
		// );
		return $db->loadObjectList();
		// return $id_user;
	}

	function AfficheTypeRapport($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select 'META1' as type, revision_rapport_meta_1 as revision, analyse_echantillon
				from rapport_meta_1
				JOIN echantillon ON id_echantillon = echantillon_rapport_meta_1
				where echantillon_rapport_meta_1 = " . $id_echantillon . "
				UNION
				Select 'META050' as type, revision_rapport_meta_050 as revision, analyse_echantillon
				from rapport_meta_050
				JOIN echantillon ON id_echantillon = echantillon_rapport_meta_050
				where echantillon_rapport_meta_050 = " . $id_echantillon . "
				UNION
				Select 'META269' as type, revision_rapport_meta_269 as revision, analyse_echantillon
				from rapport_meta_269
				JOIN echantillon ON id_echantillon = echantillon_rapport_meta_269
				where echantillon_rapport_meta_269 = " . $id_echantillon . "
				UNION
				Select 'META269v2' as type, revision_rapport_meta_269_v2 as revision, analyse_echantillon
				from rapport_meta_269_v2
				JOIN echantillon ON id_echantillon = echantillon_rapport_meta_269_v2
				where echantillon_rapport_meta_269_v2 = " . $id_echantillon . "
				UNION
				Select 'META269v3' as type, revision_rapport_meta_269_v3 as revision, analyse_echantillon
				from rapport_meta_269_v3
				JOIN echantillon ON id_echantillon = echantillon_rapport_meta_269_v3
				where echantillon_rapport_meta_269_v3 = " . $id_echantillon . "
				UNION
				Select 'MATERIAU' as type, revision_rapport_materiau as revision, analyse_echantillon
				from rapport_materiau
				JOIN echantillon ON id_echantillon = echantillon_rapport_materiau
				where echantillon_rapport_materiau = " . $id_echantillon . "
				UNION
				Select 'MEST' as type, revision_rapport_mest as revision, analyse_echantillon
				from rapport_mest
				JOIN echantillon ON id_echantillon = echantillon_rapport_mest
				where echantillon_rapport_mest = " . $id_echantillon . "
				order by revision DESC
				limit 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$rapport = $db->loadObjectList();
		return $rapport[0];
	}

	function AfficheZoneHomogene($id_zone_homogene) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_homogene
				where id_zone_homogene = " . $id_zone_homogene;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheZoneTravail($id_zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail
				where id_zone_travail = " . $id_zone_travail;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function DisableChantier($id_chantier) {
		$data = new stdClass();
		$data->id_chantier = $id_chantier;
		$data->disable_chantier = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('chantier', $data, 'id_chantier');
	}

	function CofracStrategieChantier($id_strategie_chantier, $cofrac) {
		$data = new stdClass();
		$data->id_strategie_chantier = $id_strategie_chantier;
		$data->cofrac_strategie_chantier = $cofrac;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('strategie_chantier', $data, 'id_strategie_chantier');
	}

	function CofracRapportFinal($id_rapport_final, $cofrac) {
		$data = new stdClass();
		$data->id_rapport_final = $id_rapport_final;
		$data->cofrac_rapport_final = $cofrac;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('rapport_final', $data, 'id_rapport_final');
	}

	function FicheEchantillon($id_echantillon) {
		$data = new stdClass();
		$data->id_echantillon = $id_echantillon;
		$data->fiche_echantillon = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('echantillon', $data, 'id_echantillon');
	}

	function ListeCommentaireRapportFinal($id_rapport_final) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from commentaire_rapport_final
				where rapport_final_commentaire_rapport_final = " . $id_rapport_final;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeCommentaireActifRapportFinal($id_rapport_final) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from commentaire_rapport_final
				where rapport_final_commentaire_rapport_final = " . $id_rapport_final . "
				and affiche_commentaire_rapport_final = 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeDataRapportFinal($id_rapport_final) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from rapport_final_data
				where rapport_final_data = " . $id_rapport_final;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportFinal($date_debut, $date_fin) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT client.*, chantier.*, echantillon.*, count_revision.NBR_REVISION, rapport_final.id_rapport_final, rapport_final.echantillon_rapport_final, rapport_final.revision_rapport_final, rapport_final.validation_rapport_final, rapport_final.pre_validation_rapport_final, rapport_final.date_validation_rapport_final, qualification.*
			FROM rapport_final as rapport_final
			INNER JOIN (
				Select rapport_final2.echantillon_rapport_final
				from rapport_final AS rapport_final2
				where ((date_validation_rapport_final between '" . $date_debut . "' and '" . $date_fin . "') OR (validation_rapport_final = 0))
				and revision_rapport_final = 0
			) AS rapport_final3 ON rapport_final3.echantillon_rapport_final = rapport_final.echantillon_rapport_final
			INNER JOIN (
				Select count(rapport_final4.id_rapport_final) as NBR_REVISION, rapport_final4.echantillon_rapport_final
				from rapport_final AS rapport_final4
				group by  rapport_final4.echantillon_rapport_final
			) AS count_revision ON count_revision.echantillon_rapport_final = rapport_final.echantillon_rapport_final
			INNER JOIN echantillon ON id_echantillon = rapport_final.echantillon_rapport_final
			INNER JOIN presta ON id_presta = pose_presta_echantillon
			INNER JOIN type_presta ON id_type_presta = type_presta
			INNER JOIN qualification ON id_qualification = qualification_type_presta
			INNER JOIN mission ON id_mission = mission_presta
			INNER JOIN chantier ON id_chantier = chantier_mission
			INNER JOIN client ON id_client = client_mission
			order by rapport_final.echantillon_rapport_final, rapport_final.revision_rapport_final";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	// function ListeStrategieChantierDate($date_debut, $date_fin){
	// $db =& GBMNet::getDBOGBMNet();
	// $query = "SELECT client.*, chantier.*, echantillon.*, count_revision.NBR_REVISION, strategie_chantier.id_strategie_chantier, strategie_chantier.echantillon_strategie_chantier, strategie_chantier.revision_strategie_chantier, strategie_chantier.validation_strategie_chantier, strategie_chantier.pre_validation_strategie_chantier, strategie_chantier.date_validation_strategie_chantier, qualification.*
	// FROM strategie_chantier as strategie_chantier

	// INNER JOIN echantillon ON id_echantillon = strategie_chantier.echantillon_strategie_chantier
	// INNER JOIN presta ON id_presta = pose_presta_echantillon
	// INNER JOIN type_presta ON id_type_presta = type_presta
	// INNER JOIN qualification ON id_qualification = qualification_type_presta
	// INNER JOIN mission ON id_mission = mission_presta
	// INNER JOIN chantier ON id_chantier = chantier_mission
	// INNER JOIN client ON id_client = client_mission
	// order by strategie_chantier.echantillon_strategie_chantier, strategie_chantier.revision_strategie_chantier";
	// $db->setQuery($query);


	// if ($db->getErrorNum()) {
	// echo $db->getErrorMsg();
	// exit;
	// }
	// return $db->loadObjectList();
	// }

	function ListeChantierStrategieChantierClient($id_client) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_chantier, nom_chantier, adresse_chantier, cp_chantier, ville_chantier
				from strategie_chantier, mission, presta, echantillon, chantier
				where revision_strategie_chantier = 0
				and validation_strategie_chantier = 1
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and client_mission = " . $id_client . "
				and chantier_mission = id_chantier
				group by id_chantier";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheCorbeilleEchantillon($id_corbeille_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM corbeille_echantillon, type_presta, qualification, detail_type_presta
				where id_corbeille_echantillon = " . $id_corbeille_echantillon . "
				and id_row_table_corbeille_echantillon <> 0
				and type_corbeille_echantillon = id_type_presta
				and qualification_type_presta = id_qualification
				and detail_type_corbeille_echantillon = id_detail_type_presta
				Order by date_mission_corbeille_echantillon ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeCorbeilleEchantillon($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT * FROM corbeille_echantillon, type_presta, qualification, detail_type_presta
				where chantier_corbeille_echantillon = " . $id_chantier . "
				and id_row_table_corbeille_echantillon <> 0
				and type_corbeille_echantillon = id_type_presta
				and qualification_type_presta = id_qualification
				and detail_type_corbeille_echantillon = id_detail_type_presta
				Order by date_mission_corbeille_echantillon ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonStrategieChantier($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_strategie_chantier, revision_strategie_chantier, id_echantillon, ref_echantillon, nom_zone_travail as zone, nom_type_mesure_strategie, date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation, '' as id_corbeille_echantillon,0 as id_mission
			from strategie_chantier, zone_travail_multi, zone_travail_multi_row, echantillon_strategie, echantillon, zone_travail, presta, detail_type_presta, mesure_strategie, contexte_mesure_strategie
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_zone_travail_multi = id_strategie_chantier
			and zone_travail_multi_row = id_zone_travail_multi
			And select_zone_travail_multi = id_zone_travail
			and type_table_echantillon_strategie = 2
			and id_row_table_echantillon_strategie = id_zone_travail_multi_row
			and echantillon_strategie = id_echantillon
			and pose_presta_echantillon = id_presta
			and detail_type_presta = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by id_echantillon
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, id_echantillon, ref_echantillon, nom_zone_homogene as zone, nom_type_mesure_strategie, date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation, '' as id_corbeille_echantillon ,0 as id_mission
			from strategie_chantier, objectif_strategie, objectif_strategie_row, echantillon_strategie, echantillon, zone_homogene, presta, detail_type_presta, mesure_strategie, contexte_mesure_strategie
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_objectif_strategie = id_strategie_chantier
			and objectif_strategie_row = id_objectif_strategie
			and type_table_echantillon_strategie = 3
			and id_row_table_echantillon_strategie = id_objectif_strategie_row
			and zone_homogene_objectif_strategie_row = id_zone_homogene
			and echantillon_strategie = id_echantillon
			and pose_presta_echantillon = id_presta
			and detail_type_presta = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by id_echantillon
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, id_echantillon, ref_echantillon, nom_zone_travail as zone, nom_type_mesure_strategie, date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation , '' as id_corbeille_echantillon,0 as id_mission
			from strategie_chantier, zone_travail_mono, zone_travail_mono_row, echantillon_strategie, echantillon, zone_travail, presta, detail_type_presta, mesure_strategie, contexte_mesure_strategie
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_zone_travail_mono = id_strategie_chantier
			and zone_travail_mono_row = id_zone_travail_mono
			and type_table_echantillon_strategie = 4
			and id_row_table_echantillon_strategie = id_zone_travail_mono_row
			and zone_travail_zone_travail_mono_row = id_zone_travail
			and echantillon_strategie = id_echantillon
			and pose_presta_echantillon = id_presta
			and detail_type_presta = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by id_echantillon
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, '0' as id_echantillon, '0' as ref_echantillon, nom_zone_travail as zone, nom_type_mesure_strategie, '' as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission_corbeille_echantillon as date_mission, date_creation_corbeille_echantillon as date_creation, id_corbeille_echantillon as id_corbeille_echantillon,0 as id_mission
			from strategie_chantier, zone_travail_multi, zone_travail_multi_row, zone_travail, detail_type_presta, mesure_strategie, contexte_mesure_strategie, corbeille_echantillon
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_zone_travail_multi = id_strategie_chantier
			and zone_travail_multi_row = id_zone_travail_multi
			And select_zone_travail_multi = id_zone_travail
			and type_table_corbeille_echantillon = 2
			and id_row_table_corbeille_echantillon = id_zone_travail_multi_row
			and detail_type_corbeille_echantillon = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, '0' as id_echantillon, '0' as ref_echantillon, nom_zone_homogene as zone, nom_type_mesure_strategie, '' as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission_corbeille_echantillon as date_mission, date_creation_corbeille_echantillon as date_creation, id_corbeille_echantillon as id_corbeille_echantillon,0 as id_mission
			from strategie_chantier, objectif_strategie, objectif_strategie_row, zone_homogene, detail_type_presta, mesure_strategie, contexte_mesure_strategie, corbeille_echantillon
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_objectif_strategie = id_strategie_chantier
			and objectif_strategie_row = id_objectif_strategie
			and type_table_corbeille_echantillon = 3
			and id_row_table_corbeille_echantillon = id_objectif_strategie_row
			and zone_homogene_objectif_strategie_row = id_zone_homogene
			and detail_type_corbeille_echantillon = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, '0' as id_echantillon, '0' as ref_echantillon, nom_zone_travail as zone, affichage_rapport_detail_type_presta, '' as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission_corbeille_echantillon as date_mission, date_creation_corbeille_echantillon as date_creation, id_corbeille_echantillon as id_corbeille_echantillon,0 as id_mission
			from strategie_chantier, zone_travail_mono, zone_travail_mono_row, zone_travail, detail_type_presta, mesure_strategie, contexte_mesure_strategie, corbeille_echantillon
			where echantillon_strategie_chantier = " . $id_echantillon . "
			and strategie_chantier_zone_travail_mono = id_strategie_chantier
			and zone_travail_mono_row = id_zone_travail_mono
			and type_table_corbeille_echantillon = 4
			and id_row_table_corbeille_echantillon = id_zone_travail_mono_row
			and zone_travail_zone_travail_mono_row = id_zone_travail
			and detail_type_corbeille_echantillon = id_detail_type_presta
			and id_detail_type_presta = detail_type_presta_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, id_echantillon2 as id_echantillon, ref_echantillon2 as ref_echantillon, nom_zone_homogene, nom_type_mesure_strategie2 as nom_type_mesure_strategie, date_pose_presta_echantillon2 as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission, date_creation, id_corbeille_echantillon, id_mission from (
				SELECT id_strategie_chantier, revision_strategie_chantier, 0 as id_echantillon2, rapport_final_mission.reference as ref_echantillon2, nom_zone_homogene, 'Rapport final' as nom_type_mesure_strategie2, date_validation as date_pose_presta_echantillon2, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation, '' as id_corbeille_echantillon, mission.id_mission as id_mission
				FROM rapport_final_mission
				JOIN mission ON mission.id_mission = rapport_final_mission.id_mission
				JOIN presta ON presta.mission_presta = mission.id_mission
				JOIN echantillon test ON test.pose_presta_echantillon = presta.id_presta
				JOIN detail_type_presta ON detail_type_presta.id_detail_type_presta = presta.detail_type_presta
				JOIN mesure_strategie ON mesure_strategie.detail_type_presta_mesure_strategie = detail_type_presta.id_detail_type_presta
				JOIN contexte_mesure_strategie ON contexte_mesure_strategie.id_contexte_mesure_strategie = mesure_strategie.contexte_mesure_strategie
				JOIN echantillon_strategie ON echantillon_strategie = id_echantillon
				JOIN objectif_strategie_row ON id_objectif_strategie_row = id_row_table_echantillon_strategie
				JOIN objectif_strategie ON id_objectif_strategie = objectif_strategie_row
				JOIN zone_homogene ON id_zone_homogene = zone_homogene_objectif_strategie_row
				JOIN strategie_chantier ON id_strategie_chantier = strategie_chantier_objectif_strategie
			
				WHERE
					rapport_final_mission.validation = 1
					AND type_table_echantillon_strategie = 3
					AND echantillon_strategie_chantier = {$id_echantillon}
			
				GROUP BY nom_pdf_contexte_mesure_strategie, nom_zone_homogene, ref_echantillon2
			
			) as RFO_ObjStrat
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, id_echantillon2 as id_echantillon, ref_echantillon2 as ref_echantillon, nom_zone_travail, nom_type_mesure_strategie2 as nom_type_mesure_strategie, date_pose_presta_echantillon2 as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission, date_creation, id_corbeille_echantillon, id_mission from (
				SELECT id_strategie_chantier, revision_strategie_chantier, 0 as id_echantillon2, rapport_final_mission.reference as ref_echantillon2, nom_zone_travail, 'Rapport final' as nom_type_mesure_strategie2, date_validation as date_pose_presta_echantillon2, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation, '' as id_corbeille_echantillon, mission.id_mission as id_mission
				FROM rapport_final_mission
				JOIN mission ON mission.id_mission = rapport_final_mission.id_mission
				JOIN presta ON presta.mission_presta = mission.id_mission
				JOIN echantillon test ON test.pose_presta_echantillon = presta.id_presta
				JOIN detail_type_presta ON detail_type_presta.id_detail_type_presta = presta.detail_type_presta
				JOIN mesure_strategie ON mesure_strategie.detail_type_presta_mesure_strategie = detail_type_presta.id_detail_type_presta
				JOIN contexte_mesure_strategie ON contexte_mesure_strategie.id_contexte_mesure_strategie = mesure_strategie.contexte_mesure_strategie
				JOIN echantillon_strategie ON echantillon_strategie = id_echantillon
				JOIN zone_travail_multi_row ON id_row_table_echantillon_strategie = id_zone_travail_multi_row
				JOIN zone_travail_multi ON zone_travail_multi_row = id_zone_travail_multi   
				JOIN zone_travail ON select_zone_travail_multi = id_zone_travail
				JOIN strategie_chantier ON strategie_chantier_zone_travail_multi = id_strategie_chantier

				WHERE
					rapport_final_mission.validation = 1
					AND type_table_echantillon_strategie = 2
					AND echantillon_strategie_chantier = {$id_echantillon}
			
				GROUP BY nom_pdf_contexte_mesure_strategie, nom_zone_travail, ref_echantillon2
			
			) as RFO_ZTMulti
			UNION
			Select id_strategie_chantier, revision_strategie_chantier, id_echantillon2 as id_echantillon, ref_echantillon2 as ref_echantillon, nom_zone_travail, nom_type_mesure_strategie2 as nom_type_mesure_strategie, date_pose_presta_echantillon2 as date_pose_presta_echantillon, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, commentaire_corbeille_echantillon, date_mission, date_creation, id_corbeille_echantillon, id_mission from (
				SELECT id_strategie_chantier, revision_strategie_chantier, 0 as id_echantillon2, rapport_final_mission.reference as ref_echantillon2, nom_zone_travail, 'Rapport final' as nom_type_mesure_strategie2, date_validation as date_pose_presta_echantillon2, nom_pdf_contexte_mesure_strategie, id_contexte_mesure_strategie, '' as commentaire_corbeille_echantillon, '' as date_mission, '' as date_creation, '' as id_corbeille_echantillon, mission.id_mission as id_mission
				FROM rapport_final_mission
				JOIN mission ON mission.id_mission = rapport_final_mission.id_mission
				JOIN presta ON presta.mission_presta = mission.id_mission
				JOIN echantillon test ON test.pose_presta_echantillon = presta.id_presta
				JOIN detail_type_presta ON detail_type_presta.id_detail_type_presta = presta.detail_type_presta
				JOIN mesure_strategie ON mesure_strategie.detail_type_presta_mesure_strategie = detail_type_presta.id_detail_type_presta
				JOIN contexte_mesure_strategie ON contexte_mesure_strategie.id_contexte_mesure_strategie = mesure_strategie.contexte_mesure_strategie
				JOIN echantillon_strategie ON echantillon_strategie = id_echantillon
				JOIN zone_travail_mono_row ON id_zone_travail_mono_row = id_row_table_echantillon_strategie
				JOIN zone_travail_mono ON id_zone_travail_mono = zone_travail_mono_row
				JOIN zone_travail ON id_zone_travail = zone_travail_zone_travail_mono_row
				JOIN strategie_chantier ON id_strategie_chantier = strategie_chantier_zone_travail_mono
			
				WHERE
					rapport_final_mission.validation = 1
					AND type_table_echantillon_strategie = 4	
					AND echantillon_strategie_chantier = {$id_echantillon}
			
				GROUP BY nom_pdf_contexte_mesure_strategie, nom_zone_travail, ref_echantillon2
			
			) as RFO_ZTMono		

			order by id_contexte_mesure_strategie, zone
			";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonChantierStrategieChantier($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_echantillon, ref_echantillon, id_strategie_chantier
				from strategie_chantier, mission, presta, echantillon
				where revision_strategie_chantier = 0
				and validation_strategie_chantier = 1
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = " . $id_chantier . "
				group by id_echantillon";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeClientStrategieChantier() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_client, nom_client, ref_client
				from client, strategie_chantier, mission, presta, echantillon
				where revision_strategie_chantier = 0
				and validation_strategie_chantier = 1
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and client_mission = id_client
				group by id_client
				order by ref_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeClientAttenteSaisieStrategieChantier() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_client, nom_client, ref_client
				from client, mission, presta, echantillon, type_presta, detail_type_presta
				where fiche_echantillon = 0
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and passage_labo_mission = 0
				and client_mission = id_client
				and id_type_presta = type_presta
				and detail_type_presta = id_detail_type_presta
				and qualification_type_presta = 17
				group by id_client
				order by ref_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeChantierClientAttenteSaisieStrategieChantier($client) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from chantier, mission, presta, echantillon, type_presta, detail_type_presta
				where fiche_echantillon = 0
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_chantier = " . $client . "
				and id_type_presta = type_presta
				and detail_type_presta = id_detail_type_presta
				and qualification_type_presta = 17
				group by id_chantier";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeContactChantierStrategie($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mailing_list_strategie, contact
				where chantier_mailing_list_strategie = '" . $id_chantier . "'
				and id_contact = contact_mailing_list_strategie
				and disable_contact = 0
				order by nom_contact ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeContactChantier($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mailing_list, contact
				where chantier_mailing_list = '" . $id_chantier . "'
				and id_contact = contact_mailing_list
				and disable_contact = 0
				order by nom_contact ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeContactSite($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		// $query = "Select *
		// from mailing_list_site, contact
		// where chantier_mailing_list_site = '".$id_chantier."'
		// and id_contact = contact_mailing_list_site
		// and disable_contact = 0
		// order by nom_contact ASC";
		$query = "Select contact.*
				from mailing_list, contact
				where chantier_mailing_list = '" . $id_chantier . "'
				and id_contact = contact_mailing_list
				and disable_contact = 0
				UNION
				Select contact.*
				from mailing_list_site, contact
				where chantier_mailing_list_site = '" . $id_chantier . "'
				and id_contact = contact_mailing_list_site
				and disable_contact = 0
				group by id_contact
				order by nom_contact ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeDuree() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				From duree
				Order by ordre_duree ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeEchantillonChantierAttenteSaisieStrategieChantier($chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mission, presta, echantillon, type_presta, detail_type_presta
				where fiche_echantillon = 0
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = " . $chantier . "
				and id_type_presta = type_presta
				and detail_type_presta = id_detail_type_presta
				and qualification_type_presta = 17
				order by ref_echantillon";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeImage($type_image, $strategie_chantier_image, $link_image) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from image
				where type_image = " . $type_image . "
				and strategie_chantier_image = " . $strategie_chantier_image . "
				and link_image = " . $link_image . "
				order by id_image ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeImageStrategieChantier($strategie_chantier_image) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from image
				where strategie_chantier_image = " . $strategie_chantier_image . "
				order by id_image ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeMesureStrategieContexteMesure($id_contexte_mesure) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mesure_strategie
				where contexte_mesure_strategie = " . $id_contexte_mesure . "
				order by diminutif_mesure_strategie ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeMesureZoneTravailMultiStrategie($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select mesure_strategie.*
				from mesure_strategie, zone_travail_multi, zone_travail_multi_row
				where strategie_chantier_zone_travail_multi = " . $id_strategie_chantier . "
				and zone_travail_multi_row = id_zone_travail_multi
				and type_mesure_zone_travail_multi_row = id_mesure_strategie
				group by id_mesure_strategie
				order by diminutif_mesure_strategie ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeMPCAStrategieChantier($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from mpca
				where strategie_chantier_mpca = " . $id_strategie_chantier . "
				order by id_mpca ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheNomZone($type_table, $id_row_table) {
		$db = JFactory::getDBOGBMNet();

		if ($type_table == 2) {
			$query = "Select *
					From zone_travail_multi, zone_travail_multi_row, zone_travail
					Where id_zone_travail_multi_row = '" . $id_row_table . "'
					And zone_travail_multi_row = id_zone_travail_multi
					And select_zone_travail_multi = id_zone_travail";

			$db->setQuery($query);

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				exit;
			}
			$NomZone = $db->loadObjectList();
			return $NomZone[0]->nom_zone_travail;
		}

		if ($type_table == 3) {
			$query = "Select *
					From objectif_strategie_row, zone_homogene
					Where id_objectif_strategie_row = '" . $id_row_table . "'
					And zone_homogene_objectif_strategie_row = id_zone_homogene";

			$db->setQuery($query);

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				exit;
			}
			$NomZone = $db->loadObjectList();
			return $NomZone[0]->nom_zone_homogene;
		}

		if ($type_table == 4) {
			$query = "Select *
					From zone_travail_mono_row, zone_travail
					Where id_zone_travail_mono_row = '" . $id_row_table . "'
					And zone_travail_zone_travail_mono_row = id_zone_travail";

			$db->setQuery($query);

			if ($db->getErrorNum()) {
				echo $db->getErrorMsg();
				exit;
			}
			$NomZone = $db->loadObjectList();
			return $NomZone[0]->nom_zone_travail;
		}
	}

	function ListeObjectifStrategieLocalisation($id_objectif_strategie_row) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from objectif_strategie_localisation
				where row_objectif_strategie_localisation = " . $id_objectif_strategie_row . "
				order by id_objectif_strategie_localisation ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeObjectifStrategieRow($id_objectif_strategie) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from objectif_strategie_row
				where objectif_strategie_row = " . $id_objectif_strategie . "
				order by id_objectif_strategie_row ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRevisionRapportFinal($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_rapport_final, revision_rapport_final, description_revision_rapport_final, date_validation_rapport_final, validation_rapport_final, valideur_rapport_final
				from rapport_final
				where echantillon_rapport_final = " . $echantillon . "
				order by revision_rapport_final ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRevisionStrategieChantier($echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_strategie_chantier, revision_strategie_chantier, description_revision_strategie_chantier, date_validation_strategie_chantier, validation_strategie_chantier, valideur_strategie_chantier
				from strategie_chantier
				where echantillon_strategie_chantier = " . $echantillon . "
				order by revision_strategie_chantier ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeStrategieChantier($id_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "select strategie.id_strategie_chantier, strategie.echantillon_strategie_chantier, max_revision, chantier_mission, ref_echantillon
				FROM strategie_chantier 
				INNER JOIN(
					SELECT MAX(revision_strategie_chantier) max_revision, MAX(id_strategie_chantier) as id_strategie_chantier, echantillon_strategie_chantier
					FROM strategie_chantier
					WHERE validation_strategie_chantier = 1
					GROUP BY  echantillon_strategie_chantier
				) as strategie ON (strategie.id_strategie_chantier = strategie_chantier.id_strategie_chantier)
				INNER JOIN echantillon ON strategie.echantillon_strategie_chantier = id_echantillon
				INNER JOIN presta ON pose_presta_echantillon = id_presta
				INNER JOIN mission ON mission_presta = id_mission
				INNER JOIN chantier ON chantier_mission = id_chantier
				WHERE id_chantier = " . $id_chantier;

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeStrategieChantierAttenteSaisie() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*
				from echantillon, presta, mission, chantier, client, type_presta
				where fiche_echantillon = 0
				and pose_presta_echantillon = id_presta
				and id_type_presta = type_presta
				and qualification_type_presta = 17
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeStrategieChantierDate($date_debut, $date_fin) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT client.*, chantier.*, echantillon.*, count_revision.NBR_REVISION, strategie_chantier.id_strategie_chantier, strategie_chantier.echantillon_strategie_chantier, strategie_chantier.revision_strategie_chantier, strategie_chantier.validation_strategie_chantier, strategie_chantier.pre_validation_strategie_chantier, strategie_chantier.date_validation_strategie_chantier, qualification.*
			FROM strategie_chantier as strategie_chantier
			INNER JOIN (
				Select strategie_chantier2.echantillon_strategie_chantier
				from strategie_chantier AS strategie_chantier2
				where ((date_validation_strategie_chantier between '" . $date_debut . "' and '" . $date_fin . "') OR (validation_strategie_chantier = 0))
				and revision_strategie_chantier = 0
			) AS strategie_chantier3 ON strategie_chantier3.echantillon_strategie_chantier = strategie_chantier.echantillon_strategie_chantier
			INNER JOIN (
				Select count(strategie_chantier4.id_strategie_chantier) as NBR_REVISION, strategie_chantier4.echantillon_strategie_chantier
				from strategie_chantier AS strategie_chantier4
				group by  strategie_chantier4.echantillon_strategie_chantier
			) AS count_revision ON count_revision.echantillon_strategie_chantier = strategie_chantier.echantillon_strategie_chantier
			INNER JOIN echantillon ON id_echantillon = strategie_chantier.echantillon_strategie_chantier
			INNER JOIN presta ON id_presta = pose_presta_echantillon
			INNER JOIN type_presta ON id_type_presta = type_presta
			INNER JOIN qualification ON id_qualification = qualification_type_presta
			INNER JOIN mission ON id_mission = mission_presta
			INNER JOIN chantier ON id_chantier = chantier_mission
			INNER JOIN client ON id_client = client_mission
			order by strategie_chantier.echantillon_strategie_chantier, strategie_chantier.revision_strategie_chantier";
		$db->setQuery($query);


		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeStrategieChantierPreValidation() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*, id_strategie_chantier, revision_strategie_chantier, date_strategie_chantier
				from echantillon, presta, mission, chantier, client, strategie_chantier
				where pre_validation_strategie_chantier = 0
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportFinalAttenteValidation() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*, id_rapport_final, revision_rapport_final
				from echantillon, presta, mission, chantier, client, rapport_final
				where pre_validation_rapport_final = 1
				and validation_rapport_final = 0
				and echantillon_rapport_final = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeStrategieChantierAttenteValidation() {
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*, id_strategie_chantier, revision_strategie_chantier
				from echantillon, presta, mission, chantier, client, strategie_chantier
				where pre_validation_strategie_chantier = 1
				and validation_strategie_chantier = 0
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeTableauDynamic($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT id_zone_travail_multi as 'ID', 
				strategie_chantier_zone_travail_multi as 'STRATEGIE_CHANTIER',
				titre_zone_travail_multi as 'TITRE',
				select_zone_travail_multi as 'SELECT',
				texte_zone_travail_multi as 'TEXTE',
				'' as 'CONTEXTE', 
				order_zone_travail_multi as 'ORDER_TABLE',
				'2' as 'TYPE_TABLE',
				zone_homogene_zone_travail_multi as 'ZH',
				remarque_zone_travail_multi as 'REMARQUE'
				FROM zone_travail_multi
				WHERE strategie_chantier_zone_travail_multi = " . $id_strategie_chantier . "
				
				UNION
				
				SELECT id_objectif_strategie as 'ID', 
				strategie_chantier_objectif_strategie as 'STRATEGIE_CHANTIER',
				'' as 'TITRE',
				'' as 'SELECT',
				'' as 'TEXTE',
				contexte_mesure_objectif_strategie as 'CONTEXTE', 
				order_objectif_strategie as 'ORDER_TABLE',
				'3' as 'TYPE_TABLE',
				'' as 'ZH',
				remarque_objectif_strategie as 'REMARQUE'
				FROM objectif_strategie
				WHERE strategie_chantier_objectif_strategie = " . $id_strategie_chantier . "
				
				UNION
				
				SELECT id_zone_travail_mono as 'ID', 
				strategie_chantier_zone_travail_mono as 'STRATEGIE_CHANTIER',
				'' as 'TITRE',
				'' as 'SELECT',
				'' as 'TEXTE',
				contexte_mesure_zone_travail_mono as 'CONTEXTE', 
				order_zone_travail_mono as 'ORDER_TABLE',
				'4' as 'TYPE_TABLE',
				zone_homogene_zone_travail_mono as 'ZH',
				remarque_zone_travail_mono as 'REMARQUE'
				FROM zone_travail_mono
				WHERE strategie_chantier_zone_travail_mono = " . $id_strategie_chantier . "
				ORDER by ORDER_TABLE";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeMesureZoneTravailMulti($id_zone_travail_multi) {
		$db = JFactory::getDBOGBMNet();

		$query = "Select nom_type_mesure_strategie, nbr_prelevement_zone_travail_multi_row
			From zone_travail_multi_row, mesure_strategie
			where zone_travail_multi_row = " . $id_zone_travail_multi . "
			and type_mesure_zone_travail_multi_row = id_mesure_strategie
			group by nom_type_mesure_strategie
			order by nom_type_mesure_strategie asc";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeSynthetiqueTableStrategieChantier($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie, nom_zone_travail as zone, 2 as type, '' as mesure, id_zone_travail_multi, '' as frequence, nbr_prelevement_zone_travail_multi_row as nbr_mesure
			From zone_travail_multi, zone_travail_multi_row, zone_travail, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_zone_travail_multi = " . $id_strategie_chantier . " 	
			And zone_travail_multi_row = id_zone_travail_multi
			And select_zone_travail_multi = id_zone_travail
			and type_mesure_zone_travail_multi_row = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by nom_pdf_contexte_mesure_strategie, nom_zone_travail
			UNION
			Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie,nom_zone_homogene as zone, 3 as type, nom_type_mesure_strategie as mesure, '' as id_zone_travail_multi, frequence_objectif_strategie_row as frequence, nbr_prelevement_objectif_strategie_row as nbr_mesure
			From objectif_strategie, objectif_strategie_row, zone_homogene, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_objectif_strategie = " . $id_strategie_chantier . "
			And objectif_strategie_row = id_objectif_strategie
			And zone_homogene_objectif_strategie_row = id_zone_homogene
			and contexte_mesure_objectif_strategie = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by nom_pdf_contexte_mesure_strategie, nom_zone_homogene
			UNION
			Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie,nom_zone_travail as zone, 4 as type, nom_type_mesure_strategie as mesure, '' as id_zone_travail_multi, frequence_zone_travail_mono_row as frequence, nbr_prelevement_zone_travail_mono_row as nbr_mesure
			From zone_travail_mono, zone_travail_mono_row, zone_travail, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_zone_travail_mono = " . $id_strategie_chantier . "
			And zone_travail_mono_row = id_zone_travail_mono
			And zone_travail_zone_travail_mono_row = id_zone_travail
			and contexte_mesure_zone_travail_mono = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			group by nom_pdf_contexte_mesure_strategie, nom_zone_travail
			order by id_contexte_mesure_strategie, zone";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeSynthetiqueStrategieChantier($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie, nom_zone_travail as zone, 2 as type, nom_type_mesure_strategie as mesure, id_zone_travail_multi, '' as frequence, nbr_prelevement_zone_travail_multi_row as nbr_mesure
			From zone_travail_multi, zone_travail_multi_row, zone_travail, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_zone_travail_multi = " . $id_strategie_chantier . " 	
			And zone_travail_multi_row = id_zone_travail_multi
			And select_zone_travail_multi = id_zone_travail
			and type_mesure_zone_travail_multi_row = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			UNION
			Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie,nom_zone_homogene as zone, 3 as type, nom_type_mesure_strategie as mesure, '' as id_zone_travail_multi, frequence_objectif_strategie_row as frequence, nbr_prelevement_objectif_strategie_row as nbr_mesure
			From objectif_strategie, objectif_strategie_row, zone_homogene, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_objectif_strategie = " . $id_strategie_chantier . "
			And objectif_strategie_row = id_objectif_strategie
			And zone_homogene_objectif_strategie_row = id_zone_homogene
			and contexte_mesure_objectif_strategie = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			UNION
			Select id_contexte_mesure_strategie, nom_pdf_contexte_mesure_strategie,nom_zone_travail as zone, 4 as type, nom_type_mesure_strategie as mesure, '' as id_zone_travail_multi, frequence_zone_travail_mono_row as frequence, nbr_prelevement_zone_travail_mono_row as nbr_mesure
			From zone_travail_mono, zone_travail_mono_row, zone_travail, contexte_mesure_strategie, mesure_strategie
			Where strategie_chantier_zone_travail_mono = " . $id_strategie_chantier . "
			And zone_travail_mono_row = id_zone_travail_mono
			And zone_travail_zone_travail_mono_row = id_zone_travail
			and contexte_mesure_zone_travail_mono = id_mesure_strategie
			and contexte_mesure_strategie = id_contexte_mesure_strategie
			order by id_contexte_mesure_strategie, zone";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneHomogene($id_strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_homogene
				where strategie_chantier_zone_homogene = " . $id_strategie_chantier . "
				order by id_zone_homogene ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneTravail($id_zone_homogene) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail
				where zone_homogene_zone_travail = " . $id_zone_homogene . "
				order by id_zone_travail ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneTravailMonoLocalisation($id_zone_travail_row) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail_mono_localisation
				where row_zone_travail_mono_localisation = " . $id_zone_travail_row . "
				order by id_zone_travail_mono_localisation ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneTravailMonoRow($id_zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail_mono_row, zone_travail
				where zone_travail_mono_row = " . $id_zone_travail . "
				and zone_travail_zone_travail_mono_row = id_zone_travail
				order by id_zone_travail_mono_row ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneTravailMultiRefProcessus($id_zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail_multi_ref_processus
				where zone_travail_multi_ref_processus = " . $id_zone_travail . "
				order by id_zone_travail_multi_ref_processus ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeZoneTravailMultiRow($id_zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from zone_travail_multi_row
				where zone_travail_multi_row = " . $id_zone_travail . "
				order by id_zone_travail_multi_row ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function NouveauImage($type_image, $strategie_chantier_image, $link_image, $nom_image, $path_image) {
		$data = new stdClass();
		$data->id_image = null;
		$data->type_image = $type_image;
		$data->strategie_chantier_image = $strategie_chantier_image;
		$data->link_image = $link_image;
		$data->nom_image = $nom_image;
		$data->path_image = $path_image;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('image', $data, 'id_image');
		return $db->insertid();
	}

	function NouveauRapportFinal($echantillon_rapport_final, $revision_rapport_final, $description_revision_rapport_final, $visite_site_rapport_final, $date_visite_site_rapport_final, $nom_visite_site_rapport_final, $conclusion_visite_site_rapport_final, $commentaire_debut_rapport_final, $commentaire_fin_rapport_final) {
		$data = new stdClass();
		$data->id_rapport_final = null;
		$data->echantillon_rapport_final = $echantillon_rapport_final;
		$data->date_rapport_final = date('Y-m-d H:i:s');
		$data->revision_rapport_final = $revision_rapport_final;
		$data->description_revision_rapport_final = $description_revision_rapport_final;
		$data->visite_site_rapport_final = $visite_site_rapport_final;
		$data->date_visite_site_rapport_final = $date_visite_site_rapport_final;
		$data->nom_visite_site_rapport_final = $nom_visite_site_rapport_final;
		$data->conclusion_visite_site_rapport_final = $conclusion_visite_site_rapport_final;
		$data->commentaire_debut_rapport_final = $commentaire_debut_rapport_final;
		$data->commentaire_fin_rapport_final = $commentaire_fin_rapport_final;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('rapport_final', $data, 'id_rapport_final');
		return $db->insertid();
	}

	function ModifierRapportFinal($id_rapport_final, $description_revision_rapport_final, $visite_site_rapport_final, $date_visite_site_rapport_final, $nom_visite_site_rapport_final, $conclusion_visite_site_rapport_final, $commentaire_debut_rapport_final, $commentaire_fin_rapport_final) {
		$data = new stdClass();
		$data->id_rapport_final = $id_rapport_final;
		$data->description_revision_rapport_final = $description_revision_rapport_final;
		$data->visite_site_rapport_final = $visite_site_rapport_final;
		$data->date_visite_site_rapport_final = $date_visite_site_rapport_final;
		$data->nom_visite_site_rapport_final = $nom_visite_site_rapport_final;
		$data->conclusion_visite_site_rapport_final = $conclusion_visite_site_rapport_final;
		$data->commentaire_debut_rapport_final = $commentaire_debut_rapport_final;
		$data->commentaire_fin_rapport_final = $commentaire_fin_rapport_final;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('rapport_final', $data, 'id_rapport_final');
	}

	function NouveauCommentaireRapportFinal($rapport_final_commentaire_rapport_final, $count_table_commentaire_rapport_final, $type_commentaire_rapport_final, $link_commentaire_rapport_final, $commentaire_rapport_final, $affiche_commentaire_rapport_final) {
		$data = new stdClass();
		$data->id_commentaire_rapport_final = null;
		$data->rapport_final_commentaire_rapport_final = $rapport_final_commentaire_rapport_final;
		$data->count_table_commentaire_rapport_final = $count_table_commentaire_rapport_final;
		$data->type_commentaire_rapport_final = $type_commentaire_rapport_final;
		$data->link_commentaire_rapport_final = $link_commentaire_rapport_final;
		$data->commentaire_rapport_final = $commentaire_rapport_final;
		$data->affiche_commentaire_rapport_final = $affiche_commentaire_rapport_final;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('commentaire_rapport_final', $data, 'id_commentaire_rapport_final');
		return $db->insertid();
	}

	function NouveauDataRapportFinal($rapport_final_data, $count_table_rapport_final_data, $zone_rapport_final_data, $titre_table_rapport_final_data, $ref_echantillon_rapport_final_data, $type_mesure_rapport_final_data, $date_pose_rapport_final_data, $resultat_rapport_final_data, $revision_rapport_final_data, $check_commentaire_rapport_final_data) {
		$data = new stdClass();
		$data->id_rapport_final_data = null;
		$data->rapport_final_data = $rapport_final_data;
		$data->count_table_rapport_final_data = $count_table_rapport_final_data;
		$data->zone_rapport_final_data = $zone_rapport_final_data;
		$data->titre_table_rapport_final_data = $titre_table_rapport_final_data;
		$data->ref_echantillon_rapport_final_data = $ref_echantillon_rapport_final_data;
		$data->type_mesure_rapport_final_data = $type_mesure_rapport_final_data;
		$data->date_pose_rapport_final_data = $date_pose_rapport_final_data;
		$data->resultat_rapport_final_data = $resultat_rapport_final_data;
		$data->revision_rapport_final_data = $revision_rapport_final_data;
		$data->check_commentaire_rapport_final_data = $check_commentaire_rapport_final_data;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('rapport_final_data', $data, 'id_rapport_final_data');
		return $db->insertid();
	}

	function NouveauMPCA($strategie_chantier_mpca, $type_mpca, $batiment_mpca, $localisation_mpca, $superficie_quantite_mpca) {
		$data = new stdClass();
		$data->id_mpca = null;
		$data->strategie_chantier_mpca = $strategie_chantier_mpca;
		$data->type_mpca = $type_mpca;
		$data->batiment_mpca = $batiment_mpca;
		$data->localisation_mpca = $localisation_mpca;
		$data->superficie_quantite_mpca = $superficie_quantite_mpca;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('mpca', $data, 'id_mpca');
	}

	function ModifierStrategieChantier($id_strategie_chantier, $description_revision_strategie_chantier, $pdt_util_normal_strategie_chantier, $suite_inci_mat_amiante_strategie_chantier, $travaux_amiante_place_strategie_chantier, $avant_trav_amiante_chantier, $pdt_trav_prele_prep_strategie_chantier, $pdt_trav_trait_amiante_strategie_chantier, $fin_trav_trait_amiante_strategie_chantier, $apres_trav_trait_amiante_strategie_chantier, $trav_entret_maint_mat_amiante_strategie_chantier, $strategie_chantier_global_strategie_chantier, $stratagie_caracterisation_processus_strategie_chantier, $bureaux_strategie_chantier, $habitation_strategie_chantier, $enseignement_strategie_chantier, $industriel_strategie_chantier, $loisirs_strategie_chantier, $commercial_strategie_chantier, $sante_strategie_chantier, $autre_strategie_chantier, $autre_texte_strategie_chantier, $site_occupe_strategie_chantier, $coactivite_mesurage_strategie_chantier, $plan_croquis_strategie_chantier, $accessibilite_securise_strategie_chantier, $accessibilite_materiel_strategie_chantier, $accessibilite_materiel_texte_strategie_chantier, $accessibilite_formation_strategie_chantier, $accessibilite_formation_texte_strategie_chantier, $accessibilite_document_strategie_chantier, $accessibilite_document_texte_strategie_chantier, $interieur_strategie_chantier, $exterieur_strategie_chantier, $niveau_empoussièrement_strategie_chantier, $perimetre_investigation_strategie_chantier, $zone_avec_confinement_strategie_chantier, $zone_sans_confinement_strategie_chantier, $en_zone_strategie_chantier, $hors_zone_strategie_chantier, $remarque_strategie_chantier, $visite_site_strategie_chantier, $date_visite_site_strategie_chantier, $nom_visite_site_strategie_chantier, $nom_accompagnateur_visite_site_strategie_chantier, $elements_visite_site_strategie_chantier, $visite_confirmation_strategie_chantier, $texte_visite_confirmation_strategie_chantier, $nbr_zone_homogene_strategie_chantier, $exigence_reglementaire_strategie_chantier, $ambiance_determination_action_urgence_strategie_chantier, $surveillance_strategie_chantier, $ambiance_strategie_chantier, $environnementale_strategie_chantier, $environnementale_incident_strategie_chantier, $etat_initial_strategie_chantier, $prepa_chantier_strategie_chantier, $operateur_prepa_chantier_strategie_chantier, $operateur_cara_processus_strategie_chantier, $operateur_autocontrole_strategie_chantier, $environnementale_hors_chantier_strategie_chantier, $environnementale_chantier_strategie_chantier, $sortie_extracteur_strategie_chantier, $suivi_zone_strategie_chantier, $approche_sas_perso_strategie_chantier, $zone_recuperation_strategie_chantier, $vestiaire_approche_strategie_chantier, $approche_sas_materiel_strategie_chantier, $avant_control_visuel_strategie_chantier, $restitution_1_strategie_chantier, $fin_chantier_strategie_chantier, $restitution_2_strategie_chantier, $liberatoire_strategie_chantier, $fin_travaux_strategie_chantier) {
		$data = new stdClass();
		$data->id_strategie_chantier = $id_strategie_chantier;
		$data->description_revision_strategie_chantier = $description_revision_strategie_chantier;
		$data->pdt_util_normal_strategie_chantier = $pdt_util_normal_strategie_chantier;
		$data->suite_inci_mat_amiante_strategie_chantier = $suite_inci_mat_amiante_strategie_chantier;
		$data->travaux_amiante_place_strategie_chantier = $travaux_amiante_place_strategie_chantier;
		$data->avant_trav_amiante_chantier = $avant_trav_amiante_chantier;
		$data->pdt_trav_prele_prep_strategie_chantier = $pdt_trav_prele_prep_strategie_chantier;
		$data->pdt_trav_trait_amiante_strategie_chantier = $pdt_trav_trait_amiante_strategie_chantier;
		$data->fin_trav_trait_amiante_strategie_chantier = $fin_trav_trait_amiante_strategie_chantier;
		$data->apres_trav_trait_amiante_strategie_chantier = $apres_trav_trait_amiante_strategie_chantier;
		$data->trav_entret_maint_mat_amiante_strategie_chantier = $trav_entret_maint_mat_amiante_strategie_chantier;
		$data->strategie_chantier_global_strategie_chantier = $strategie_chantier_global_strategie_chantier;
		$data->stratagie_caracterisation_processus_strategie_chantier = $stratagie_caracterisation_processus_strategie_chantier;
		$data->bureaux_strategie_chantier = $bureaux_strategie_chantier;
		$data->habitation_strategie_chantier = $habitation_strategie_chantier;
		$data->enseignement_strategie_chantier = $enseignement_strategie_chantier;
		$data->industriel_strategie_chantier = $industriel_strategie_chantier;
		$data->loisirs_strategie_chantier = $loisirs_strategie_chantier;
		$data->commercial_strategie_chantier = $commercial_strategie_chantier;
		$data->sante_strategie_chantier = $sante_strategie_chantier;
		$data->autre_strategie_chantier = $autre_strategie_chantier;
		$data->autre_texte_strategie_chantier = $autre_texte_strategie_chantier;
		$data->site_occupe_strategie_chantier = $site_occupe_strategie_chantier;
		$data->coactivite_mesurage_strategie_chantier = $coactivite_mesurage_strategie_chantier;
		$data->plan_croquis_strategie_chantier = $plan_croquis_strategie_chantier;
		$data->accessibilite_securise_strategie_chantier = $accessibilite_securise_strategie_chantier;
		$data->accessibilite_materiel_strategie_chantier = $accessibilite_materiel_strategie_chantier;
		$data->accessibilite_materiel_texte_strategie_chantier = $accessibilite_materiel_texte_strategie_chantier;
		$data->accessibilite_formation_strategie_chantier = $accessibilite_formation_strategie_chantier;
		$data->accessibilite_formation_texte_strategie_chantier = $accessibilite_formation_texte_strategie_chantier;
		$data->accessibilite_document_strategie_chantier = $accessibilite_document_strategie_chantier;
		$data->accessibilite_document_texte_strategie_chantier = $accessibilite_document_texte_strategie_chantier;
		$data->interieur_strategie_chantier = $interieur_strategie_chantier;
		$data->exterieur_strategie_chantier = $exterieur_strategie_chantier;
		$data->niveau_empoussièrement_strategie_chantier = $niveau_empoussièrement_strategie_chantier;
		$data->perimetre_investigation_strategie_chantier = $perimetre_investigation_strategie_chantier;
		$data->zone_avec_confinement_strategie_chantier = $zone_avec_confinement_strategie_chantier;
		$data->zone_sans_confinement_strategie_chantier = $zone_sans_confinement_strategie_chantier;
		$data->en_zone_strategie_chantier = $en_zone_strategie_chantier;
		$data->hors_zone_strategie_chantier = $hors_zone_strategie_chantier;
		$data->remarque_strategie_chantier = $remarque_strategie_chantier;
		$data->visite_site_strategie_chantier = $visite_site_strategie_chantier;
		$data->date_visite_site_strategie_chantier = $date_visite_site_strategie_chantier;
		$data->nom_visite_site_strategie_chantier = $nom_visite_site_strategie_chantier;
		$data->nom_accompagnateur_visite_site_strategie_chantier = $nom_accompagnateur_visite_site_strategie_chantier;
		$data->elements_visite_site_strategie_chantier = $elements_visite_site_strategie_chantier;
		$data->visite_confirmation_strategie_chantier = $visite_confirmation_strategie_chantier;
		$data->texte_visite_confirmation_strategie_chantier = $texte_visite_confirmation_strategie_chantier;
		$data->nbr_zone_homogene_strategie_chantier = $nbr_zone_homogene_strategie_chantier;
		$data->exigence_reglementaire_strategie_chantier = $exigence_reglementaire_strategie_chantier;
		$data->ambiance_determination_action_urgence_strategie_chantier = $ambiance_determination_action_urgence_strategie_chantier;
		$data->surveillance_strategie_chantier = $surveillance_strategie_chantier;
		$data->ambiance_strategie_chantier = $ambiance_strategie_chantier;
		$data->environnementale_strategie_chantier = $environnementale_strategie_chantier;
		$data->environnementale_incident_strategie_chantier = $environnementale_incident_strategie_chantier;
		$data->etat_initial_strategie_chantier = $etat_initial_strategie_chantier;
		$data->prepa_chantier_strategie_chantier = $prepa_chantier_strategie_chantier;
		$data->operateur_prepa_chantier_strategie_chantier = $operateur_prepa_chantier_strategie_chantier;
		$data->operateur_cara_processus_strategie_chantier = $operateur_cara_processus_strategie_chantier;
		$data->operateur_autocontrole_strategie_chantier = $operateur_autocontrole_strategie_chantier;
		$data->environnementale_hors_chantier_strategie_chantier = $environnementale_hors_chantier_strategie_chantier;
		$data->environnementale_chantier_strategie_chantier = $environnementale_chantier_strategie_chantier;
		$data->sortie_extracteur_strategie_chantier = $sortie_extracteur_strategie_chantier;
		$data->suivi_zone_strategie_chantier = $suivi_zone_strategie_chantier;
		$data->approche_sas_perso_strategie_chantier = $approche_sas_perso_strategie_chantier;
		$data->zone_recuperation_strategie_chantier = $zone_recuperation_strategie_chantier;
		$data->vestiaire_approche_strategie_chantier = $vestiaire_approche_strategie_chantier;
		$data->approche_sas_materiel_strategie_chantier = $approche_sas_materiel_strategie_chantier;
		$data->avant_control_visuel_strategie_chantier = $avant_control_visuel_strategie_chantier;
		$data->restitution_1_strategie_chantier = $restitution_1_strategie_chantier;
		$data->fin_chantier_strategie_chantier = $fin_chantier_strategie_chantier;
		$data->restitution_2_strategie_chantier = $restitution_2_strategie_chantier;
		$data->liberatoire_strategie_chantier = $liberatoire_strategie_chantier;
		$data->fin_travaux_strategie_chantier = $fin_travaux_strategie_chantier;


		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('strategie_chantier', $data, 'id_strategie_chantier');
	}

	function ModifierCommentaireStrategieChantier($id_strategie_chantier, $commentaire_rapport_final_strategie_chantier) {
		$data = new stdClass();
		$data->id_strategie_chantier = $id_strategie_chantier;
		$data->commentaire_rapport_final_strategie_chantier = $commentaire_rapport_final_strategie_chantier;


		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('strategie_chantier', $data, 'id_strategie_chantier');
	}

	function NouveauStrategieChantier($echantillon_strategie_chantier, $date_strategie_chantier, $revision_strategie_chantier, $description_revision_strategie_chantier, $pre_validation_strategie_chantier, $validation_strategie_chantier, $date_validation_strategie_chantier, $cofrac_strategie_chantier, $valideur_strategie_chantier, $pdt_util_normal_strategie_chantier, $suite_inci_mat_amiante_strategie_chantier, $travaux_amiante_place_strategie_chantier, $avant_trav_amiante_chantier, $pdt_trav_prele_prep_strategie_chantier, $pdt_trav_trait_amiante_strategie_chantier, $fin_trav_trait_amiante_strategie_chantier, $apres_trav_trait_amiante_strategie_chantier, $trav_entret_maint_mat_amiante_strategie_chantier, $strategie_chantier_global_strategie_chantier, $stratagie_caracterisation_processus_strategie_chantier, $bureaux_strategie_chantier, $habitation_strategie_chantier, $enseignement_strategie_chantier, $industriel_strategie_chantier, $loisirs_strategie_chantier, $commercial_strategie_chantier, $sante_strategie_chantier, $autre_strategie_chantier, $autre_texte_strategie_chantier, $site_occupe_strategie_chantier, $coactivite_mesurage_strategie_chantier, $plan_croquis_strategie_chantier, $accessibilite_securise_strategie_chantier, $accessibilite_materiel_strategie_chantier, $accessibilite_materiel_texte_strategie_chantier, $accessibilite_formation_strategie_chantier, $accessibilite_formation_texte_strategie_chantier, $accessibilite_document_strategie_chantier, $accessibilite_document_texte_strategie_chantier, $interieur_strategie_chantier, $exterieur_strategie_chantier, $niveau_empoussièrement_strategie_chantier, $perimetre_investigation_strategie_chantier, $zone_avec_confinement_strategie_chantier, $zone_sans_confinement_strategie_chantier, $en_zone_strategie_chantier, $hors_zone_strategie_chantier, $remarque_strategie_chantier, $visite_site_strategie_chantier, $date_visite_site_strategie_chantier, $nom_visite_site_strategie_chantier, $nom_accompagnateur_visite_site_strategie_chantier, $elements_visite_site_strategie_chantier, $visite_confirmation_strategie_chantier, $texte_visite_confirmation_strategie_chantier, $nbr_zone_homogene_strategie_chantier, $exigence_reglementaire_strategie_chantier, $ambiance_determination_action_urgence_strategie_chantier, $surveillance_strategie_chantier, $ambiance_strategie_chantier, $environnementale_strategie_chantier, $environnementale_incident_strategie_chantier, $etat_initial_strategie_chantier, $prepa_chantier_strategie_chantier, $operateur_prepa_chantier_strategie_chantier, $operateur_cara_processus_strategie_chantier, $operateur_autocontrole_strategie_chantier, $environnementale_hors_chantier_strategie_chantier, $environnementale_chantier_strategie_chantier, $sortie_extracteur_strategie_chantier, $suivi_zone_strategie_chantier, $approche_sas_perso_strategie_chantier, $zone_recuperation_strategie_chantier, $vestiaire_approche_strategie_chantier, $approche_sas_materiel_strategie_chantier, $avant_control_visuel_strategie_chantier, $restitution_1_strategie_chantier, $fin_chantier_strategie_chantier, $restitution_2_strategie_chantier, $liberatoire_strategie_chantier, $fin_travaux_strategie_chantier) {
		$data = new stdClass();
		$data->id_strategie_chantier = null;
		$data->echantillon_strategie_chantier = $echantillon_strategie_chantier;
		$data->date_strategie_chantier = $date_strategie_chantier;
		$data->revision_strategie_chantier = $revision_strategie_chantier;
		$data->description_revision_strategie_chantier = $description_revision_strategie_chantier;
		$data->pre_validation_strategie_chantier = $pre_validation_strategie_chantier;
		$data->validation_strategie_chantier = $validation_strategie_chantier;
		$data->date_validation_strategie_chantier = $date_validation_strategie_chantier;
		$data->cofrac_strategie_chantier = $cofrac_strategie_chantier;
		$data->valideur_strategie_chantier = $valideur_strategie_chantier;
		$data->pdt_util_normal_strategie_chantier = $pdt_util_normal_strategie_chantier;
		$data->suite_inci_mat_amiante_strategie_chantier = $suite_inci_mat_amiante_strategie_chantier;
		$data->travaux_amiante_place_strategie_chantier = $travaux_amiante_place_strategie_chantier;
		$data->avant_trav_amiante_chantier = $avant_trav_amiante_chantier;
		$data->pdt_trav_prele_prep_strategie_chantier = $pdt_trav_prele_prep_strategie_chantier;
		$data->pdt_trav_trait_amiante_strategie_chantier = $pdt_trav_trait_amiante_strategie_chantier;
		$data->fin_trav_trait_amiante_strategie_chantier = $fin_trav_trait_amiante_strategie_chantier;
		$data->apres_trav_trait_amiante_strategie_chantier = $apres_trav_trait_amiante_strategie_chantier;
		$data->trav_entret_maint_mat_amiante_strategie_chantier = $trav_entret_maint_mat_amiante_strategie_chantier;
		$data->strategie_chantier_global_strategie_chantier = $strategie_chantier_global_strategie_chantier;
		$data->stratagie_caracterisation_processus_strategie_chantier = $stratagie_caracterisation_processus_strategie_chantier;
		$data->bureaux_strategie_chantier = $bureaux_strategie_chantier;
		$data->habitation_strategie_chantier = $habitation_strategie_chantier;
		$data->enseignement_strategie_chantier = $enseignement_strategie_chantier;
		$data->industriel_strategie_chantier = $industriel_strategie_chantier;
		$data->loisirs_strategie_chantier = $loisirs_strategie_chantier;
		$data->commercial_strategie_chantier = $commercial_strategie_chantier;
		$data->sante_strategie_chantier = $sante_strategie_chantier;
		$data->autre_strategie_chantier = $autre_strategie_chantier;
		$data->autre_texte_strategie_chantier = $autre_texte_strategie_chantier;
		$data->site_occupe_strategie_chantier = $site_occupe_strategie_chantier;
		$data->coactivite_mesurage_strategie_chantier = $coactivite_mesurage_strategie_chantier;
		$data->plan_croquis_strategie_chantier = $plan_croquis_strategie_chantier;
		$data->accessibilite_securise_strategie_chantier = $accessibilite_securise_strategie_chantier;
		$data->accessibilite_materiel_strategie_chantier = $accessibilite_materiel_strategie_chantier;
		$data->accessibilite_materiel_texte_strategie_chantier = $accessibilite_materiel_texte_strategie_chantier;
		$data->accessibilite_formation_strategie_chantier = $accessibilite_formation_strategie_chantier;
		$data->accessibilite_formation_texte_strategie_chantier = $accessibilite_formation_texte_strategie_chantier;
		$data->accessibilite_document_strategie_chantier = $accessibilite_document_strategie_chantier;
		$data->accessibilite_document_texte_strategie_chantier = $accessibilite_document_texte_strategie_chantier;
		$data->interieur_strategie_chantier = $interieur_strategie_chantier;
		$data->exterieur_strategie_chantier = $exterieur_strategie_chantier;
		$data->niveau_empoussièrement_strategie_chantier = $niveau_empoussièrement_strategie_chantier;
		$data->perimetre_investigation_strategie_chantier = $perimetre_investigation_strategie_chantier;
		$data->zone_avec_confinement_strategie_chantier = $zone_avec_confinement_strategie_chantier;
		$data->zone_sans_confinement_strategie_chantier = $zone_sans_confinement_strategie_chantier;
		$data->en_zone_strategie_chantier = $en_zone_strategie_chantier;
		$data->hors_zone_strategie_chantier = $hors_zone_strategie_chantier;
		$data->remarque_strategie_chantier = $remarque_strategie_chantier;
		$data->visite_site_strategie_chantier = $visite_site_strategie_chantier;
		$data->date_visite_site_strategie_chantier = $date_visite_site_strategie_chantier;
		$data->nom_visite_site_strategie_chantier = $nom_visite_site_strategie_chantier;
		$data->nom_accompagnateur_visite_site_strategie_chantier = $nom_accompagnateur_visite_site_strategie_chantier;
		$data->elements_visite_site_strategie_chantier = $elements_visite_site_strategie_chantier;
		$data->visite_confirmation_strategie_chantier = $visite_confirmation_strategie_chantier;
		$data->texte_visite_confirmation_strategie_chantier = $texte_visite_confirmation_strategie_chantier;
		$data->nbr_zone_homogene_strategie_chantier = $nbr_zone_homogene_strategie_chantier;
		$data->exigence_reglementaire_strategie_chantier = $exigence_reglementaire_strategie_chantier;
		$data->ambiance_determination_action_urgence_strategie_chantier = $ambiance_determination_action_urgence_strategie_chantier;
		$data->surveillance_strategie_chantier = $surveillance_strategie_chantier;
		$data->ambiance_strategie_chantier = $ambiance_strategie_chantier;
		$data->environnementale_strategie_chantier = $environnementale_strategie_chantier;
		$data->environnementale_incident_strategie_chantier = $environnementale_incident_strategie_chantier;
		$data->etat_initial_strategie_chantier = $etat_initial_strategie_chantier;
		$data->prepa_chantier_strategie_chantier = $prepa_chantier_strategie_chantier;
		$data->operateur_prepa_chantier_strategie_chantier = $operateur_prepa_chantier_strategie_chantier;
		$data->operateur_cara_processus_strategie_chantier = $operateur_cara_processus_strategie_chantier;
		$data->operateur_autocontrole_strategie_chantier = $operateur_autocontrole_strategie_chantier;
		$data->environnementale_hors_chantier_strategie_chantier = $environnementale_hors_chantier_strategie_chantier;
		$data->environnementale_chantier_strategie_chantier = $environnementale_chantier_strategie_chantier;
		$data->sortie_extracteur_strategie_chantier = $sortie_extracteur_strategie_chantier;
		$data->suivi_zone_strategie_chantier = $suivi_zone_strategie_chantier;
		$data->approche_sas_perso_strategie_chantier = $approche_sas_perso_strategie_chantier;
		$data->zone_recuperation_strategie_chantier = $zone_recuperation_strategie_chantier;
		$data->vestiaire_approche_strategie_chantier = $vestiaire_approche_strategie_chantier;
		$data->approche_sas_materiel_strategie_chantier = $approche_sas_materiel_strategie_chantier;
		$data->avant_control_visuel_strategie_chantier = $avant_control_visuel_strategie_chantier;
		$data->restitution_1_strategie_chantier = $restitution_1_strategie_chantier;
		$data->fin_chantier_strategie_chantier = $fin_chantier_strategie_chantier;
		$data->restitution_2_strategie_chantier = $restitution_2_strategie_chantier;
		$data->liberatoire_strategie_chantier = $liberatoire_strategie_chantier;
		$data->fin_travaux_strategie_chantier = $fin_travaux_strategie_chantier;


		$db = JFactory::getDBOGBMNet();
		$db->insertObject('strategie_chantier', $data, 'id_strategie_chantier');
		return $db->insertid();
	}

	function NouveauZoneHomogene($strategie_chantier_zone_homogene, $nom_zone_homogene, $mpca_zone_homogene, $degradation_zone_homogene, $type_zone_homogene, $etancheite_zone_homogene, $circulation_air_zone_homogene, $choc_zone_homogene, $activite_zone_homogene, $frequentation_zone_homogene, $remarque_zone_homogene) {
		$data = new stdClass();
		$data->id_zone_homogene = null;
		$data->strategie_chantier_zone_homogene = $strategie_chantier_zone_homogene;
		$data->nom_zone_homogene = $nom_zone_homogene;
		$data->mpca_zone_homogene = $mpca_zone_homogene;
		$data->degradation_zone_homogene = $degradation_zone_homogene;
		$data->type_zone_homogene = $type_zone_homogene;
		$data->etancheite_zone_homogene = $etancheite_zone_homogene;
		$data->circulation_air_zone_homogene = $circulation_air_zone_homogene;
		$data->choc_zone_homogene = $choc_zone_homogene;
		$data->activite_zone_homogene = $activite_zone_homogene;
		$data->frequentation_zone_homogene = $frequentation_zone_homogene;
		$data->remarque_zone_homogene = $remarque_zone_homogene;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_homogene', $data, 'id_zone_homogene');
		return $db->insertid();
	}

	function NouveauObjectifStrategie($strategie_chantier_objectif_strategie, $contexte_mesure_objectif_strategie, $remarque_objectif_strategie, $order_objectif_strategie) {
		$data = new stdClass();
		$data->id_objectif_strategie = null;
		$data->strategie_chantier_objectif_strategie = $strategie_chantier_objectif_strategie;
		$data->contexte_mesure_objectif_strategie = $contexte_mesure_objectif_strategie;
		$data->remarque_objectif_strategie = $remarque_objectif_strategie;
		$data->order_objectif_strategie = $order_objectif_strategie;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('objectif_strategie', $data, 'id_objectif_strategie');
		return $db->insertid();
	}

	function NouveauObjectifStrategieRow($objectif_strategie_row, $zone_homogene_objectif_strategie_row, $nbr_objectif_strategie_row, $exterieur_objectif_strategie_row, $observation_objectif_strategie_row, $nbr_prelevement_objectif_strategie_row, $frequence_objectif_strategie_row, $frequence_texte_objectif_strategie_row, $simulation_humaine_objectif_strategie_row) {
		$data = new stdClass();
		$data->id_objectif_strategie_row = null;
		$data->objectif_strategie_row = $objectif_strategie_row;
		$data->zone_homogene_objectif_strategie_row = $zone_homogene_objectif_strategie_row;
		$data->nbr_objectif_strategie_row = $nbr_objectif_strategie_row;
		$data->exterieur_objectif_strategie_row = $exterieur_objectif_strategie_row;
		$data->observation_objectif_strategie_row = $observation_objectif_strategie_row;
		$data->nbr_prelevement_objectif_strategie_row = $nbr_prelevement_objectif_strategie_row;
		$data->frequence_objectif_strategie_row = $frequence_objectif_strategie_row;
		$data->frequence_texte_objectif_strategie_row = $frequence_texte_objectif_strategie_row;
		$data->simulation_humaine_objectif_strategie_row = $simulation_humaine_objectif_strategie_row;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('objectif_strategie_row', $data, 'id_objectif_strategie_row');
		return $db->insertid();
	}

	function NouveauObjectifStrategieLocalisation($id_objectif_mesure_row, $nom_objectif_strategie_localisation, $description_objectif_strategie_localisation) {
		$data = new stdClass();
		$data->id_objectif_strategie_localisation = null;
		$data->row_objectif_strategie_localisation = $id_objectif_mesure_row;
		$data->nom_objectif_strategie_localisation = $nom_objectif_strategie_localisation;
		$data->description_objectif_strategie_localisation = $description_objectif_strategie_localisation;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('objectif_strategie_localisation', $data, 'id_objectif_strategie_localisation');
		return $db->insertid();
	}

	function NouveauZoneTravailMono($strategie_chantier_zone_travail_mono, $contexte_mesure_zone_travail_mono, $zone_homogene_zone_travail_mono, $remarque_zone_travail_mono, $order_zone_travail_mono) {
		$data = new stdClass();
		$data->id_zone_travail_mono = null;
		$data->strategie_chantier_zone_travail_mono = $strategie_chantier_zone_travail_mono;
		$data->contexte_mesure_zone_travail_mono = $contexte_mesure_zone_travail_mono;
		$data->zone_homogene_zone_travail_mono = $zone_homogene_zone_travail_mono;
		$data->remarque_zone_travail_mono = $remarque_zone_travail_mono;
		$data->order_zone_travail_mono = $order_zone_travail_mono;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_mono', $data, 'id_zone_travail_mono');
		return $db->insertid();
	}

	function NouveauZoneTravailMonoRow($zone_travail_mono_row, $zone_travail_zone_travail_mono_row, $nbr_zone_travail_mono_row, $exterieur_zone_travail_mono_row, $observation_zone_travail_mono_row, $nbr_prelevement_zone_travail_mono_row, $frequence_zone_travail_mono_row, $frequence_texte_zone_travail_mono_row, $simulation_humaine_zone_travail_mono_row) {
		$data = new stdClass();
		$data->id_zone_travail_mono_row = null;
		$data->zone_travail_mono_row = $zone_travail_mono_row;
		$data->zone_travail_zone_travail_mono_row = $zone_travail_zone_travail_mono_row;
		$data->nbr_zone_travail_mono_row = $nbr_zone_travail_mono_row;
		$data->exterieur_zone_travail_mono_row = $exterieur_zone_travail_mono_row;
		$data->observation_zone_travail_mono_row = $observation_zone_travail_mono_row;
		$data->nbr_prelevement_zone_travail_mono_row = $nbr_prelevement_zone_travail_mono_row;
		$data->frequence_zone_travail_mono_row = $frequence_zone_travail_mono_row;
		$data->frequence_texte_zone_travail_mono_row = $frequence_texte_zone_travail_mono_row;
		$data->simulation_humaine_zone_travail_mono_row = $simulation_humaine_zone_travail_mono_row;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_mono_row', $data, 'id_zone_travail_mono_row');
		return $db->insertid();
	}

	function NouveauZoneTravailMonoLocalisation($row_zone_travail_mono_localisation, $nom_zone_travail_mono_localisation, $description_zone_travail_mono_localisation) {
		$data = new stdClass();
		$data->id_zone_travail_mono_localisation = null;
		$data->row_zone_travail_mono_localisation = $row_zone_travail_mono_localisation;
		$data->nom_zone_travail_mono_localisation = $nom_zone_travail_mono_localisation;
		$data->description_zone_travail_mono_localisation = $description_zone_travail_mono_localisation;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_mono_localisation', $data, 'id_zone_travail_mono_localisation');
		return $db->insertid();
	}

	function NouveauZoneTravail($zone_homogene_zone_travail, $nom_zone_travail, $confinement_zone_travail, $confinement_texte_zone_travail) {
		$data = new stdClass();
		$data->id_zone_travail = null;
		$data->zone_homogene_zone_travail = $zone_homogene_zone_travail;
		$data->nom_zone_travail = $nom_zone_travail;
		$data->confinement_zone_travail = $confinement_zone_travail;
		$data->confinement_texte_zone_travail = $confinement_texte_zone_travail;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail', $data, 'id_zone_travail');
		return $db->insertid();
	}

	function NouveauZoneTravailMulti($strategie_chantier_zone_travail, $titre_zone_travail, $zone_homogene_zone_travail, $select_zone_travail, $texte_zone_travail, $remarque_zone_travail, $order_zone_travail) {
		$data = new stdClass();
		$data->id_zone_travail_multi = null;
		$data->strategie_chantier_zone_travail_multi = $strategie_chantier_zone_travail;
		$data->titre_zone_travail_multi = $titre_zone_travail;
		$data->zone_homogene_zone_travail_multi = $zone_homogene_zone_travail;
		$data->select_zone_travail_multi = $select_zone_travail;
		$data->texte_zone_travail_multi = $texte_zone_travail;
		$data->remarque_zone_travail_multi = $remarque_zone_travail;
		$data->order_zone_travail_multi = $order_zone_travail;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_multi', $data, 'id_zone_travail_multi');
		return $db->insertid();
	}

	function NouveauZoneTravailMultiRefProcessus($zone_travail_multi, $ref_processus_zone_travail_multi_ref_processus, $materiau_zone_travail_multi_ref_processus, $technique_retrait_zone_travail_multi_ref_processus, $protection_collective_zone_travail_multi_ref_processus) {
		$data = new stdClass();
		$data->id_zone_travail_multi_ref_processus = null;
		$data->zone_travail_multi_ref_processus = $zone_travail_multi;
		$data->ref_processus_zone_travail_multi_ref_processus = $ref_processus_zone_travail_multi_ref_processus;
		$data->materiau_zone_travail_multi_ref_processus = $materiau_zone_travail_multi_ref_processus;
		$data->technique_retrait_zone_travail_multi_ref_processus = $technique_retrait_zone_travail_multi_ref_processus;
		$data->protection_collective_zone_travail_multi_ref_processus = $protection_collective_zone_travail_multi_ref_processus;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_multi_ref_processus', $data, 'id_zone_travail_multi_ref_processus');
		return $db->insertid();
	}

	function NouveauZoneTravailMultiRow($zone_travail_multi, $type_mesure_zone_travail_row, $nbr_prelevement_zone_travail_row, $nom_ref_processus_zone_travail_row, $intitule_ref_processus_zone_travail_row) {
		$data = new stdClass();
		$data->id_zone_travail_multi_row = null;
		$data->zone_travail_multi_row = $zone_travail_multi;
		$data->type_mesure_zone_travail_multi_row = $type_mesure_zone_travail_row;
		$data->nbr_prelevement_zone_travail_multi_row = $nbr_prelevement_zone_travail_row;
		$data->nom_ref_processus_zone_travail_multi_row = $nom_ref_processus_zone_travail_row;
		$data->intitule_ref_processus_zone_travail_multi_row = $intitule_ref_processus_zone_travail_row;

		$db = JFactory::getDBOGBMNet();
		$db->insertObject('zone_travail_multi_row', $data, 'id_zone_travail_multi_row');
		return $db->insertid();
	}

	function PreValidation($id_strategie_chantier) {
		$data = new stdClass();
		$data->id_strategie_chantier = $id_strategie_chantier;
		$data->pre_validation_strategie_chantier = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('strategie_chantier', $data, 'id_strategie_chantier');


		$query = "Select *
				from strategie_chantier
				where id_strategie_chantier = " . $id_strategie_chantier . "
				and pre_validation_strategie_chantier = 1";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function PreValidationRapportFinal($id_rapport_final) {
		$data = new stdClass();
		$data->id_rapport_final = $id_rapport_final;
		$data->pre_validation_rapport_final = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('rapport_final', $data, 'id_rapport_final');


		$query = "Select *
				from rapport_final
				where id_rapport_final = " . $id_rapport_final . "
				and pre_validation_rapport_final = 1";
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	function SupprimerCommentaireRapportFinal($id_rapport_final) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('commentaire_rapport_final'));
		$query->where($db->nameQuote('rapport_final_commentaire_rapport_final') . '=' . $db->quote($id_rapport_final));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerDataRapportFinal($id_rapport_final_data) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('rapport_final_data'));
		$query->where($db->nameQuote('rapport_final_data') . '=' . $db->quote($id_rapport_final_data));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerMPCA($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('mpca'));
		$query->where($db->nameQuote('strategie_chantier_mpca') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerImage($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('image'));
		$query->where($db->nameQuote('strategie_chantier_image') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneHomogene($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_homogene'));
		$query->where($db->nameQuote('strategie_chantier_zone_homogene') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerObjectifStrategie($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('objectif_strategie'));
		$query->where($db->nameQuote('strategie_chantier_objectif_strategie') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerObjectifStrategieRow($objectif_strategie) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('objectif_strategie_row'));
		$query->where($db->nameQuote('objectif_strategie_row') . '=' . $db->quote($objectif_strategie));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerObjectifStrategieLocalisation($objectif_strategie_row) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('objectif_strategie_localisation'));
		$query->where($db->nameQuote('row_objectif_strategie_localisation') . '=' . $db->quote($objectif_strategie_row));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravail($zone_homogene) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail'));
		$query->where($db->nameQuote('zone_homogene_zone_travail') . '=' . $db->quote($zone_homogene));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMono($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_mono'));
		$query->where($db->nameQuote('strategie_chantier_zone_travail_mono') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMonoRow($zone_travail_mono) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_mono_row'));
		$query->where($db->nameQuote('zone_travail_mono_row') . '=' . $db->quote($zone_travail_mono));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMonoLocalisation($zone_travail_mono_row) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_mono_localisation'));
		$query->where($db->nameQuote('row_zone_travail_mono_localisation') . '=' . $db->quote($zone_travail_mono_row));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMulti($strategie_chantier) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_multi'));
		$query->where($db->nameQuote('strategie_chantier_zone_travail_multi') . '=' . $db->quote($strategie_chantier));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMultiRefProcessus($zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_multi_ref_processus'));
		$query->where($db->nameQuote('zone_travail_multi_ref_processus') . '=' . $db->quote($zone_travail));
		$db->setQuery($query);
		$db->query();
	}

	function SupprimerZoneTravailMultiRow($zone_travail) {
		$db = JFactory::getDBOGBMNet();
		$query = $db->getQuery(true);
		$query->delete($db->nameQuote('zone_travail_multi_row'));
		$query->where($db->nameQuote('zone_travail_multi_row') . '=' . $db->quote($zone_travail));
		$db->setQuery($query);
		$db->query();
	}

	function ValidationStrategieChantier($id_strategie_chantier, $valideur) {
		$data = new stdClass();
		$data->id_strategie_chantier = $id_strategie_chantier;
		$data->valideur_strategie_chantier = $valideur;
		$data->date_validation_strategie_chantier = date("Y-m-d H:i:s");
		$data->validation_strategie_chantier = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('strategie_chantier', $data, 'id_strategie_chantier');
	}

	function ValidationRapportFinal($id_rapport_final, $valideur) {
		$data = new stdClass();
		$data->id_rapport_final = $id_rapport_final;
		$data->valideur_rapport_final = $valideur;
		$data->date_validation_rapport_final = date("Y-m-d H:i:s");
		$data->validation_rapport_final = 1;

		$db = JFactory::getDBOGBMNet();
		$db->UpdateObject('rapport_final', $data, 'id_rapport_final');
	}
}
