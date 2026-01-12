
<?php
defined('_JEXEC') or die;
require_once(URL_MODELE . "rapport.php");
$model = new RapportModel;
class gbmnetBackModel
{
	function GetSharingKey()
	{
		$config = JFactory::getConfig();
		return $config->get('sharingkey');
	}

	function CheckRemoteToken($token)
	{

		$config = JFactory::getConfig();
		$remotetoken = $config->get('frontToken');
		// $urltemp = $remotetoken . "&task=CheckTokenCEAPIC&token=" . $token . "&format=raw";
		//echo $urltemp;
		//die();
		return file_get_contents($remotetoken . "&task=CheckTokenCEAPIC&token=" . $token . "&format=raw");
	}
	/////////////////////////////////////////// DATABASE /////////////////////////////////////////////////////////////
	function ListeClient()
	{
		// echo "back database request";
		// die();
		// $db = GBMNet::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		// var_dump($db);
		// die();
		$query = "Select id_client, ref_client, nom_client, '1' as 'type_client'
			from client where id_client <> 0
			UNION
			Select id_client_analyse as id_client, ref_client_analyse as id_client, nom_client_analyse as id_client, '2' as 'type_client'
			from client_analyse where id_client_analyse <> 0
			order by type_client ASC, nom_client ASC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	function ListeChantier($id_client)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		// $query = "Select *
		// from chantier
		// join (
		// select chantier_mission, date_mission
		// from mission
		// where client_mission = " . $id_client . "
		// group by chantier_mission
		// order by id_mission
		// ) mission ON chantier_mission = id_chantier
		// where client_chantier = " . $id_client . "
		// order by id_chantier desc";
		// $lol = "testing working";
		// return $lol;
		$query = "SELECT 
					chantier.*, 
					premiere_mesure.*, 
					mission.*,
					STRAT.*
				FROM chantier 
				JOIN (
					SELECT chantier_mission, date_mission
					FROM mission
					WHERE client_mission = {$id_client}
					GROUP by chantier_mission
					ORDER by id_mission
				) mission ON mission.chantier_mission = id_chantier
				LEFT JOIN (
					SELECT STRAT.id_strategie_chantier as id_strat, chantier_mission, 1 as type_strategie
					FROM strategie_chantier STRAT
					JOIN echantillon ECH ON ECH.id_echantillon = STRAT.echantillon_strategie_chantier
					JOIN presta ON presta.id_presta = ECH.pose_presta_echantillon
					JOIN mission ON mission.id_mission = presta.mission_presta
					WHERE mission.client_mission = {$id_client}
					AND revision_strategie_chantier = 0
					AND validation_strategie_chantier = 1

					UNION ALL

					SELECT STRAT_v1.id as id_strat, chantier_mission, 2 as type_strategie
					FROM strategie_chantier_v1 STRAT_v1
					JOIN echantillon ECH ON ECH.id_echantillon = STRAT_v1.id_echantillon
					JOIN presta ON id_presta = pose_presta_echantillon
					JOIN mission ON mission_presta = id_mission
					WHERE client_mission = {$id_client}
					AND revision = 0
					AND validation = 1
				) STRAT ON STRAT.chantier_mission = mission.chantier_mission
				LEFT JOIN (
					select id_chantier as group_chantier, date_pose_presta_echantillon
					from chantier
					JOIN mission ON chantier_mission = id_chantier
					JOIN presta ON mission_presta = id_mission
					JOIN (select * from echantillon where ref_echantillon NOT LIKE 'VS-%' order by date_pose_presta_echantillon) echantillon ON pose_presta_echantillon = id_presta
					WHERE client_mission = {$id_client}
					GROUP BY group_chantier
				) premiere_mesure ON premiere_mesure.group_chantier = mission.chantier_mission
				WHERE client_chantier = {$id_client}
				ORDER by chantier.id_chantier desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function CheckClientChantier($id_client, $id_chantier)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();

		$query = "Select client_chantier
					from chantier
					where id_chantier = " . $id_chantier;
		$db->setQuery($query);

		$oneChantier = $db->loadObjectList();

		if ($oneChantier[0]->client_chantier == $id_client) {
			return "true";
		} else {
			return "false";
		}
	}

	function ListeStrategieChantier($id_chantier)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT * FROM (SELECT 
					ECH.id_echantillon, 
					CONCAT(ECH.ref_echantillon,'-v',STRAT.revision_strategie_chantier) as reference,
					1 as type_strategie, 
					STRAT.id_strategie_chantier as idStrat

				FROM 
					strategie_chantier STRAT
				JOIN echantillon ECH 	ON ECH.id_echantillon = STRAT.echantillon_strategie_chantier
				JOIN presta 			ON presta.id_presta = ECH.pose_presta_echantillon
				JOIN mission 			ON mission.id_mission = presta.mission_presta
				WHERE 
					validation_strategie_chantier = 1
					AND chantier_mission = {$id_chantier}				
				
				UNION ALL
				
				SELECT 
					ECH.id_echantillon, 
					CONCAT(ECH.ref_echantillon,'-v',STRAT.revision) as reference,
					2 as type_strategie,
					STRAT.id as idStrat

				FROM 
					strategie_chantier_v1 STRAT
				JOIN echantillon ECH 	ON ECH.id_echantillon = STRAT.id_echantillon
				JOIN presta 			ON presta.id_presta = ECH.pose_presta_echantillon
				JOIN mission 			ON mission.id_mission = presta.mission_presta
				WHERE 
					validation = 1
					AND chantier_mission = {$id_chantier}
				) as test
				ORDER BY 
					id_echantillon, 
					reference DESC
				";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function getTypeLastStrategie($id_echantillon)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
					1 as type_strategie,
					max_id as id_strategie
				FROM strategie_chantier STRAT
				JOIN (
					SELECT 
						MAX(id_strategie_chantier) as max_id, 
						echantillon_strategie_chantier
					FROM strategie_chantier
					WHERE echantillon_strategie_chantier = {$id_echantillon}
					AND validation_strategie_chantier = 1
					GROUP BY echantillon_strategie_chantier
				) as max_strat ON max_strat.max_id = STRAT.id_strategie_chantier
				WHERE STRAT.echantillon_strategie_chantier = {$id_echantillon}
				AND validation_strategie_chantier = 1
				
				UNION ALL
				
				SELECT 
					2 as type_strategie,
					max_id as id_strategie
				FROM strategie_chantier_v1 STRAT
				JOIN (
					SELECT 
						MAX(id) as max_id, 
						id_echantillon
					FROM strategie_chantier_v1
					WHERE id_echantillon = {$id_echantillon}
					AND revision = 0
					AND validation = 1
					GROUP BY id_echantillon
				) as max_strat ON max_strat.max_id = STRAT.id
				WHERE STRAT.id_echantillon = {$id_echantillon}
				AND validation = 1";
		$db->setQuery($query);
		return $db->loadObject();
	}


	function ListeRapportChantier($id_chantier)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "
			  select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_acr`.`revision_rapport_acr` AS `revision`,`rapport_acr`.`validation_rapport_acr` AS `validation`,`rapport_acr`.`fiche_labo_rapport_acr` AS `fiche_labo`,`rapport_acr`.`id_rapport_acr` AS `rapport`,'ACR' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_acr`) where ((`rapport_acr`.`echantillon_rapport_acr` = `echantillon`.`id_echantillon`) and (validation_rapport_acr = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_mest`.`revision_rapport_mest` AS `revision`,`rapport_mest`.`validation_rapport_mest` AS `validation`,`rapport_mest`.`fiche_labo_rapport_mest` AS `fiche_labo`,`rapport_mest`.`id_rapport_mest` AS `rapport`,'MEST' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_mest`) where ((`rapport_mest`.`echantillon_rapport_mest` = `echantillon`.`id_echantillon`) and (validation_rapport_mest = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_1`.`revision_rapport_meta_1` AS `revision`,`rapport_meta_1`.`validation_rapport_meta_1` AS `validation`,`rapport_meta_1`.`fiche_labo_rapport_meta_1` AS `fiche_labo`,`rapport_meta_1`.`id_rapport_meta_1` AS `rapport`,'META_1_1' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_1`) where ((`rapport_meta_1`.`echantillon_rapport_meta_1` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_1 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_1_2`.`revision_rapport_meta_1_2` AS `revision`,`rapport_meta_1_2`.`validation_rapport_meta_1_2` AS `validation`,`rapport_meta_1_2`.`fiche_labo_rapport_meta_1_2` AS `fiche_labo`,`rapport_meta_1_2`.`id_rapport_meta_1_2` AS `rapport`,'META_1_2' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_1_2`) where ((`rapport_meta_1_2`.`echantillon_rapport_meta_1_2` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_1_2 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_3`.`revision_rapport_meta_3` AS `revision`,`rapport_meta_3`.`validation_rapport_meta_3` AS `validation`,`rapport_meta_3`.`fiche_labo_rapport_meta_3` AS `fiche_labo`,`rapport_meta_3`.`id_rapport_meta_3` AS `rapport`,'META_3_1' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_3`) where ((`rapport_meta_3`.`echantillon_rapport_meta_3` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_3 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_3_2`.`revision_rapport_meta_3_2` AS `revision`,`rapport_meta_3_2`.`validation_rapport_meta_3_2` AS `validation`,`rapport_meta_3_2`.`fiche_labo_rapport_meta_3_2` AS `fiche_labo`,`rapport_meta_3_2`.`id_rapport_meta_3_2` AS `rapport`,'META_3_2' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_3_2`) where ((`rapport_meta_3_2`.`echantillon_rapport_meta_3_2` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_3_2 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_lingette`.`revision_rapport_lingette` AS `revision`,`rapport_lingette`.`validation_rapport_lingette` AS `validation`,`rapport_lingette`.`fiche_labo_rapport_lingette` AS `fiche_labo`,`rapport_lingette`.`id_rapport_lingette` AS `rapport`,'LINGETTE' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_lingette`) where ((`rapport_lingette`.`echantillon_rapport_lingette` = `echantillon`.`id_echantillon`) and (validation_rapport_lingette = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_materiau`.`revision_rapport_materiau` AS `revision`,`rapport_materiau`.`validation_rapport_materiau` AS `validation`,`rapport_materiau`.`fiche_labo_rapport_materiau` AS `fiche_labo`,`rapport_materiau`.`id_rapport_materiau` AS `rapport`,'MATERIAU' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_materiau`) where ((`rapport_materiau`.`echantillon_rapport_materiau` = `echantillon`.`id_echantillon`) and (validation_rapport_materiau = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_269`.`revision_rapport_meta_269` AS `revision`,`rapport_meta_269`.`validation_rapport_meta_269` AS `validation`,`rapport_meta_269`.`fiche_labo_rapport_meta_269` AS `fiche_labo`,`rapport_meta_269`.`id_rapport_meta_269` AS `rapport`,'META_269' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_269`) where ((`rapport_meta_269`.`echantillon_rapport_meta_269` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_269 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_269_v2`.`revision_rapport_meta_269_v2` AS `revision`,`rapport_meta_269_v2`.`validation_rapport_meta_269_v2` AS `validation`,`rapport_meta_269_v2`.`fiche_labo_rapport_meta_269_v2` AS `fiche_labo`,`rapport_meta_269_v2`.`id_rapport_meta_269_v2` AS `rapport`,'META_269_v2' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_269_v2`) where ((`rapport_meta_269_v2`.`echantillon_rapport_meta_269_v2` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_269_v2 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_269_v3`.`revision_rapport_meta_269_v3` AS `revision`,`rapport_meta_269_v3`.`validation_rapport_meta_269_v3` AS `validation`,`rapport_meta_269_v3`.`fiche_labo_rapport_meta_269_v3` AS `fiche_labo`,`rapport_meta_269_v3`.`id_rapport_meta_269_v3` AS `rapport`,'META_269_v3' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_269_v3`) where ((`rapport_meta_269_v3`.`echantillon_rapport_meta_269_v3` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_269_v3 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`)) 
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_meta_050`.`revision_rapport_meta_050` AS `revision`,`rapport_meta_050`.`validation_rapport_meta_050` AS `validation`,`rapport_meta_050`.`fiche_labo_rapport_meta_050` AS `fiche_labo`,`rapport_meta_050`.`id_rapport_meta_050` AS `rapport`,'META_050' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_meta_050`) where ((`rapport_meta_050`.`echantillon_rapport_meta_050` = `echantillon`.`id_echantillon`) and (validation_rapport_meta_050 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_air_plomb`.`revision_rapport_air_plomb` AS `revision`,`rapport_air_plomb`.`validation_rapport_air_plomb` AS `validation`,`rapport_air_plomb`.`fiche_labo_rapport_air_plomb` AS `fiche_labo`,`rapport_air_plomb`.`id_rapport_air_plomb` AS `rapport`,'AIR_PLOMB' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_air_plomb`) where ((`rapport_air_plomb`.`echantillon_rapport_air_plomb` = `echantillon`.`id_echantillon`) and (validation_rapport_air_plomb = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_air_plomb_v2`.`revision_rapport_air_plomb_v2` AS `revision`,`rapport_air_plomb_v2`.`validation_rapport_air_plomb_v2` AS `validation`,`rapport_air_plomb_v2`.`fiche_labo_rapport_air_plomb_v2` AS `fiche_labo`,`rapport_air_plomb_v2`.`id_rapport_air_plomb_v2` AS `rapport`,'AIR_PLOMB_v2' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_air_plomb_v2`) where ((`rapport_air_plomb_v2`.`echantillon_rapport_air_plomb_v2` = `echantillon`.`id_echantillon`) and (validation_rapport_air_plomb_v2 = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_lixiviation`.`revision_rapport_lixiviation` AS `revision`,`rapport_lixiviation`.`validation_rapport_lixiviation` AS `validation`,`rapport_lixiviation`.`fiche_labo_rapport_lixiviation` AS `fiche_labo`,`rapport_lixiviation`.`id_rapport_lixiviation` AS `rapport`,'LIXIVIATION' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_lixiviation`) where ((`rapport_lixiviation`.`echantillon_rapport_lixiviation` = `echantillon`.`id_echantillon`) and (validation_rapport_lixiviation = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_ecaille_peinture`.`revision_rapport_ecaille_peinture` AS `revision`,`rapport_ecaille_peinture`.`validation_rapport_ecaille_peinture` AS `validation`,`rapport_ecaille_peinture`.`fiche_labo_rapport_ecaille_peinture` AS `fiche_labo`,`rapport_ecaille_peinture`.`id_rapport_ecaille_peinture` AS `rapport`,'ECAILLE_PEINTURE' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_ecaille_peinture`) where ((`rapport_ecaille_peinture`.`echantillon_rapport_ecaille_peinture` = `echantillon`.`id_echantillon`) and (validation_rapport_ecaille_peinture = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		union select id_echantillon, `echantillon`.`ref_echantillon` AS `ref_echantillon`,`qualification`.`nom_qualification` AS `nom_qualification`,`methode_prelevement`.`nom_methode_prelevement` AS `nom_methode_prelevement`,`detail_type_presta`.`affichage_rapport_detail_type_presta` AS `affichage_rapport_detail_type_presta`,`client`.`nom_client` AS `nom_client`,`chantier`.`nom_chantier` AS `nom_chantier`,`echantillon`.`date_pose_presta_echantillon` AS `date_pose_presta_echantillon`,`echantillon`.`date_recup_presta_echantillon` AS `date_recup_presta_echantillon`,`rapport_lingette_plomb`.`revision_rapport_lingette_plomb` AS `revision`,`rapport_lingette_plomb`.`validation_rapport_lingette_plomb` AS `validation`,`rapport_lingette_plomb`.`fiche_labo_rapport_lingette_plomb` AS `fiche_labo`,`rapport_lingette_plomb`.`id_rapport_lingette_plomb` AS `rapport`,'LINGETTE_PLOMB' AS `type`,`echantillon`.`analyse_echantillon` AS `analyse_echantillon`,`echantillon`.`fiche_analyse_echantillon` AS `fiche_analyse_echantillon` from (((((((((`echantillon` join `presta`) join `type_presta`) join `qualification`) join `detail_type_presta`) join `methode_prelevement`) join `chantier`) join `client`) join `mission`) join `rapport_lingette_plomb`) where ((`rapport_lingette_plomb`.`echantillon_rapport_lingette_plomb` = `echantillon`.`id_echantillon`) and (validation_rapport_lingette_plomb = 1) and (`echantillon`.`pose_presta_echantillon` = `presta`.`id_presta`) and (`mission`.`id_mission` = `presta`.`mission_presta`) and (`client`.`id_client` = `mission`.`client_mission`) and (chantier_mission = " . $id_chantier . ") and (`chantier`.`id_chantier` = `mission`.`chantier_mission`) and (`presta`.`type_presta` = `type_presta`.`id_type_presta`) and (`type_presta`.`qualification_type_presta` = `qualification`.`id_qualification`) and (`presta`.`detail_type_presta` = `detail_type_presta`.`id_detail_type_presta`) and (`detail_type_presta`.`methode_detail_type_presta` = `methode_prelevement`.`id_methode_prelevement`))
		order by date_pose_presta_echantillon desc, ref_echantillon, revision";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}















	function AfficheRapport($id_echantillon, $id_rapport)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_050 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_050
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_050 = id_echantillon
				and id_rapport_meta_050 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269_v2 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269_v2
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269_v2 = id_echantillon
				and id_rapport_meta_269_v2 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269_v3 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269_v3
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269_v3 = id_echantillon
				and id_rapport_meta_269_v3 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_mest as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_mest
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_mest = id_echantillon
				and id_rapport_mest = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_1 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_1
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_1 = id_echantillon
				and id_rapport_meta_1 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269 = id_echantillon
				and id_rapport_meta_269 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_air_plomb as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_air_plomb
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_air_plomb = id_echantillon
				and id_rapport_air_plomb = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_air_plomb_v2 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_air_plomb_v2
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_air_plomb_v2 = id_echantillon
				and id_rapport_air_plomb_v2 = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_lingette_plomb as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_lingette_plomb
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_lingette_plomb = id_echantillon
				and id_rapport_lingette_plomb = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_acr as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_acr
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_acr = id_echantillon
				and id_rapport_acr = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_lingette as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_lingette
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_lingette = id_echantillon
				and id_rapport_lingette = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_lixiviation as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_lixiviation
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_lixiviation = id_echantillon
				and id_rapport_lixiviation = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_ecaille_peinture as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_ecaille_peinture
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_ecaille_peinture = id_echantillon
				and id_rapport_ecaille_peinture = " . $id_rapport . "
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_materiau as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_materiau
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_materiau = id_echantillon
				and id_rapport_materiau = " . $id_rapport;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function CheckClientEchantillon($id_client, $id_echantillon)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select id_echantillon, client_mission
				from echantillon, presta, mission
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and mission_presta = id_mission
				and client_mission = " . $id_client;
		$db->setQuery($query);

		if (count($db->loadObjectList()) <> 0) {
			return "true";
		} else {
			return "false";
		}
	}

	function AfficheRapportEchantillon($id_echantillon)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_050 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_050
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_050 = id_echantillon
				and validation_rapport_meta_050 = 1
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269_v2 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269_v2
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269_v2 = id_echantillon
				and validation_rapport_meta_269_v2 = 1
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269_v3 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269_v3
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269_v3 = id_echantillon
				and validation_rapport_meta_269_v3 = 1
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_mest as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_mest
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_mest = id_echantillon
				and validation_rapport_mest = 1
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_1 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_1
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_1 = id_echantillon
				and validation_rapport_meta_1 = 1
				UNION
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_meta_269 as revision
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_meta_269
				where id_echantillon = " . $id_echantillon . "
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement
				and echantillon_rapport_meta_269 = id_echantillon
				and validation_rapport_meta_269 = 1
				order by revision DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}





	/////////////////////////////////////////////////////////DownloadAllRapportChantierBack//////////////////////////////////////////
	function ListeEchantillonChantier($id_chantier)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "select id_echantillon, ref_echantillon, nom_client, nom_chantier, nom_qualification, nom_methode_prelevement
		from chantier
		JOIN mission ON chantier_mission = id_chantier
		JOIN presta ON mission_presta = id_mission
		JOIN echantillon ON pose_presta_echantillon = id_presta
		JOIN client ON client_mission = id_client
		JOIN detail_type_presta ON id_detail_type_presta = detail_type_presta
		JOIN type_presta ON id_type_presta = type_presta_detail_type_presta
		JOIN qualification ON id_qualification = qualification_type_presta
		JOIN methode_prelevement ON methode_detail_type_presta = id_methode_prelevement
		where id_chantier = " . $id_chantier;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	function ListeTypeRapport($type_rapport)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from type_rapport ";
		if ($type_rapport <> '')
			$query .= "where type_rapport = '" . $type_rapport . "'";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	function AfficheLastRevisionRapport($id_echantillon, $type_rapport)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select revision_" . $type_rapport . " as revision
				from " . $type_rapport . "
				where echantillon_" . $type_rapport . " = " . $id_echantillon . "
				and validation_" . $type_rapport . " = 1
				order by revision_" . $type_rapport . " desc
				LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}



	////////////////////////////////////////////  TelechargeStrategie  ///////////////////////////////////////////

	function CheckClientStrategie($id_client, $id_strategie)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
					ECH.id_echantillon, 
					client_mission
				FROM strategie_chantier STRAT
				JOIN echantillon ECH ON ECH.id_echantillon = STRAT.echantillon_strategie_chantier
				JOIN presta ON id_presta = pose_presta_echantillon
				JOIN mission ON id_mission = mission_presta
				WHERE id_strategie_chantier = {$id_strategie}
				AND client_mission = {$id_client}
				
				UNION ALL
				
				SELECT 
					ECH.id_echantillon, 
					client_mission
				FROM strategie_chantier_v1 STRAT
				JOIN echantillon ECH ON ECH.id_echantillon = STRAT.id_echantillon
				JOIN presta ON id_presta = pose_presta_echantillon
				JOIN mission ON id_mission = mission_presta
				WHERE STRAT.id = {$id_strategie}
				AND client_mission = {$id_client}";
		$db->setQuery($query);

		if (count($db->loadObjectList()) <> 0) {
			return "true";
		} else {
			return "false";
		}
	}


	function AfficheStrategie($id_strategie_chantier, $typeStrategie)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		if ($typeStrategie == "1") {
			$query = "
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_strategie_chantier, 
				CONCAT(echantillon.ref_echantillon,'-V',revision_strategie_chantier) as reference
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, strategie_chantier
				where id_strategie_chantier = " . $id_strategie_chantier . "
				and echantillon_strategie_chantier = id_echantillon
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement";
		} else {
			$query = "SELECT
					v1.*, 
					CONCAT(ech.reference,'-V',revision) as reference
				FROM 
					strategie_chantier_v1 v1
				JOIN echantillon ech on ech.id_echantillon = v1.id_echantillon
				WHERE 
					v1.id = " . $id_strategie_chantier;
		}
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	// ======================================================================================================
	// Liste stratégie chantier d'un client
	// ======================================================================================================

	function ListeStrategieClient($id_client)
	{
		// $db = JFactory::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
			*
			FROM
			(
			SELECT 
				id_echantillon, 
				ref_echantillon, 
				id_strategie_chantier, 
				echantillon_strategie_chantier, 
				revision_strategie_chantier, 
				nom_chantier, 
				adresse_chantier, 
				cp_chantier, 
				ville_chantier,
				1 as type_strategie
			FROM 
				strategie_chantier, mission, presta, echantillon, chantier, client
			WHERE 
				validation_strategie_chantier = 1
				AND echantillon_strategie_chantier = id_echantillon
				AND pose_presta_echantillon = id_presta
				AND mission_presta = id_mission
				AND chantier_mission = id_chantier
				AND client_mission = " . $id_client . "
				AND client_mission = id_client

			UNION ALL

			SELECT 
				STRAT.id_echantillon, 
				ECH.ref_echantillon, 
				STRAT.id as id_strategie_chantier, 
				STRAT.id_echantillon as echantillon_strategie_chantier, 
				STRAT.revision as revision_strategie_chantier, 
				chantier.nom_chantier, 
				chantier.adresse_chantier, 
				chantier.cp_chantier, 
				chantier.ville_chantier,
				2 as type_strategie
			FROM 
				strategie_chantier_v1 STRAT
			
			INNER JOIN echantillon ECH 	ON ECH.id_echantillon = STRAT.id_echantillon
			INNER JOIN presta 			ON presta.id_presta = ECH.pose_presta_echantillon
			INNER JOIN mission 			ON mission.id_mission = presta.mission_presta
			INNER JOIN chantier 		ON chantier_mission = chantier.id_chantier
			INNER JOIN client			ON client.id_client = mission.client_mission
			
			WHERE 
				STRAT.validation = 1				
				AND client.id_client = " . $id_client . "
				
			) as infos			

			ORDER BY 
				echantillon_strategie_chantier desc, 
				revision_strategie_chantier asc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	// ======================================================================================================
	// Liste tout les processus d'un client
	// ======================================================================================================
	function ListeEchantillonProcessusClient($id_client)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select 
			date_recup_presta_echantillon, 
			id_echantillon, 
			ref_echantillon,  
			nom_chantier, 
			adresse_chantier, 
			ville_chantier, 
			cp_chantier
		From 
			echantillon
		JOIN presta ON pose_presta_echantillon = id_presta
		JOIN mission ON mission_presta = id_mission
		JOIN chantier ON chantier_mission = id_chantier
		LEFT JOIN rapport_meta_269 ON echantillon_rapport_meta_269 = id_echantillon
		LEFT JOIN rapport_meta_269_v2 ON echantillon_rapport_meta_269_v2 = id_echantillon
		LEFT JOIN rapport_meta_269_v3 ON echantillon_rapport_meta_269_v3 = id_echantillon
		WHERE 
			detail_type_presta in (137,182)
			and client_mission = " . $id_client . "
			and (id_rapport_meta_269 IS NOT NULL OR id_rapport_meta_269_v2 IS NOT NULL OR id_rapport_meta_269_v3 IS NOT NULL)
		group by 
			id_echantillon
		order by 
			YEAR(date_creation_echantillon) DESC, MONTH(date_creation_echantillon) DESC, mois_ref_echantillon DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}



	// ======================================================================================================
	// Liste les rapports finaux d'un client
	// ======================================================================================================

	function ListeRapportsFinauxClient($id_client)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select client.*, chantier.*, echantillon.*, id_rapport_final, revision_rapport_final
				from echantillon, presta, mission, chantier, client, rapport_final
				where validation_rapport_final = 1
				and echantillon_rapport_final = id_echantillon
				and pose_presta_echantillon = id_presta
				and client_mission = " . $id_client . "
				and mission_presta = id_mission
				and chantier_mission = id_chantier
				and client_mission = id_client
				order by YEAR(date_creation_echantillon) DESC, MONTH(date_creation_echantillon) DESC, mois_ref_echantillon DESC, echantillon_rapport_final, revision_rapport_final asc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	// ======================================================================================================
	// Affiche les informations de la stratgie
	// ======================================================================================================

	function AfficheRapportFinal($id_rapport_final)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "
				Select echantillon.*, presta.*, type_presta.*, qualification.*, duree.*, detail_type_presta.*, methode_prelevement.*, mission.*, client.*, chantier.*, revision_rapport_final
				from echantillon, presta, type_presta, qualification, duree, detail_type_presta, methode_prelevement, mission, client, chantier, rapport_final
				where id_rapport_final = " . $id_rapport_final . "
				and echantillon_rapport_final = id_echantillon
				and pose_presta_echantillon = id_presta
				and type_presta = id_type_presta
				and mission_presta = id_mission
				and client_mission = id_client
				and chantier_mission = id_chantier
				and qualification_type_presta = id_qualification
				and duree_presta = id_duree
				and detail_type_presta = id_detail_type_presta
				and methode_detail_type_presta = id_methode_prelevement";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}



	////////////////////////////////////////////////////// mes-dossier ////////////////////////////////////////////////////////
	function ListeDossierExterne($id_client, $date_debut, $date_fin, $sharingKey)
	{
		$db = JFactory::getDBOGBMNet();

		// $typeAnalyse = RapportModel::getTypeRapportByType(RapportModel::TYPE_RAPPORT_ANALYSE);
		//IFNULL(exo.validation,0) as validation_exo					
		// LEFT JOIN analyse_exotique_multi exo ON exo.id_dossier = dossier.id_dossier
		// GESTION REVISONS + DERNIERE REVISION + VALIDER				
		// materiau_multi

		$query = "SELECT 
					dossier.id_dossier, 					
					chantier_analyse_dossier as ref_dossier_client, 
					ref_dossier,
					DATE_FORMAT(date_creation_dossier,'%d/%m/%Y') as date_dossier,
					0 as is_multi	,
					0 as nb_ech							

				FROM 
					dossier
												
				WHERE 
					client_dossier = {$id_client}
					AND type_dossier = 2
					AND date_reception_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
				";
		// var_dump($query);
		// die();
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$dossiers = $db->loadObjectList();

		//SET LES ANALYSES SIMPLES
		$echantillonsSimple = $this->detailDossierMono($id_client, $date_debut, $date_fin, $sharingKey);
		//var_dump($echantillonsSimple);
		foreach ($dossiers as $dossier) {
			$echantillonsTemp = array_values(array_filter($echantillonsSimple, function ($echantillon) use ($dossier) {
				return $echantillon->id_dossier == $dossier->id_dossier;
			}));
			$dossier->nb_ech = count($echantillonsTemp);
			$dossier->echantillons = $echantillonsTemp;
		}

		//SET LES ANALYSES MULTIPLES
		$echantillonsMulti = $this->detailsDossierMulti($id_client, $date_debut, $date_fin, $sharingKey);
		foreach ($dossiers as $dossier) {
			$echantillonsTemp = array_values(array_filter($echantillonsMulti, function ($echantillon) use ($dossier) {
				return $echantillon->id_dossier == $dossier->id_dossier;
			}));
			if (count($echantillonsTemp) > 0) {
				$dossier->nb_ech = count($echantillonsTemp);
				$dossier->is_multi = true;
				$dossier->echantillons = $echantillonsTemp;
			}
		}

		return $dossiers;
	}




	function detailDossierMono($id_client, $date_debut, $date_fin, $sharingKey)
	{

		$db = JFactory::getDBOGBMNet();
		$typeAnalyse = RapportModel::getTypeRapportByTypeAndMulti(RapportModel::TYPE_RAPPORT_ANALYSE, 0);

		$query = "SELECT 
					echantillon_analyse.id_echantillon_analyse, 
					echantillon_analyse.ref_client_echantillon_analyse,
					echantillon_analyse.ref_echantillon_analyse,
					dossier.id_dossier,					
					analyse.*,
					'1' as has_mono,
					libelle_analyse_externe_prestation as nom_qualification_analyse
				FROM 
					dossier,
					echantillon_analyse
									
				INNER JOIN (";

		$queryArray = [];

		foreach ($typeAnalyse as $oneTypeAnalyse) {
			$shortNameColumn = $oneTypeAnalyse->type_colonne_name;
			$nomTypeRapport = $oneTypeAnalyse->nom_type_rapport;
			if ($shortNameColumn == "0") {
				$idColumn 		   = "id_{$nomTypeRapport}";
				$revisionColumn    = "revision_{$nomTypeRapport}";
				$echantillonColumn = "echantillon_{$nomTypeRapport}";
				$validationColumn  = "validation_{$nomTypeRapport}";
				$typeDossierColumn = "type_dossier_{$nomTypeRapport}";
			}

			if ($shortNameColumn == "1") {
				$idColumn 		   = "id";
				$revisionColumn    = "revision";
				$echantillonColumn = "id_echantillon";
				$validationColumn  = "validation";
				$typeDossierColumn = "type_dossier";
			}

			$queryArray[] = "SELECT 
							{$echantillonColumn} AS echantillon							
							
						FROM 
							{$nomTypeRapport}
						WHERE 
							{$nomTypeRapport}.{$revisionColumn} = 0
							AND {$nomTypeRapport}.{$validationColumn} = 1
							AND {$nomTypeRapport}.{$typeDossierColumn} = 2
						GROUP BY 
							{$nomTypeRapport}.{$echantillonColumn}";
		}

		$queryStr = implode(" UNION ", $queryArray);

		$query .= " {$queryStr}
				) AS analyse ON id_echantillon_analyse = analyse.echantillon

				LEFT JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				LEFT JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				LEFT JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse

				WHERE 					
					client_dossier = {$id_client}
					AND dossier.id_dossier= dossier_echantillon_analyse
					AND type_dossier = 2
					AND date_reception_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'									
				ORDER BY 				
					echantillon_analyse.id_echantillon_analyse";
		//echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$echantillons = $db->loadObjectList();

		foreach ($echantillons as $echantillon) {
			$echantillon->tokenEchantillon = md5($echantillon->id_echantillon_analyse . $sharingKey);
		}

		return $echantillons;
	}


	function detailsDossierMulti($id_client, $date_debut, $date_fin, $sharingKey)
	{
		$db = JFactory::getDBOGBMNet();
		$typeAnalyse = RapportModel::getTypeRapportByTypeAndMulti(RapportModel::TYPE_RAPPORT_ANALYSE, 1);

		$query = "SELECT 
					echantillon_analyse.id_echantillon_analyse, 
					echantillon_analyse.ref_client_echantillon_analyse,
					echantillon_analyse.ref_echantillon_analyse,
					dossier.id_dossier,					
					analyse_dossier.*,
					libelle_analyse_externe_prestation as nom_qualification_analyse

				FROM 
					dossier
				INNER JOIN echantillon_analyse ON dossier.id_dossier = dossier_echantillon_analyse
									
				INNER JOIN (";

		$queryArray = [];

		foreach ($typeAnalyse as $oneTypeAnalyse) {
			$shortNameColumn = $oneTypeAnalyse->type_colonne_name;
			$nomTypeRapport = $oneTypeAnalyse->nom_type_rapport;
			if ($shortNameColumn == "0") {
				$idColumn 		   = "id_{$nomTypeRapport}";
				$revisionColumn    = "revision_{$nomTypeRapport}";
				$dossierColumn 	   = "dossier_{$nomTypeRapport}";
				$validationColumn  = "validation_{$nomTypeRapport}";
			}

			if ($shortNameColumn == "1") {
				$idColumn 		   = "id";
				$revisionColumn    = "revision";
				$dossierColumn 	   = "id_dossier";
				$validationColumn  = "validation";
				$typeDossierColumn = "type_dossier";
			}

			$queryArray[] = "SELECT 
							{$dossierColumn} AS id_dossier_analyse,
							{$oneTypeAnalyse->has_mono_type_rapport} as has_mono					
						FROM 
							{$nomTypeRapport}
						WHERE 
							{$nomTypeRapport}.{$revisionColumn} = 0
							AND {$nomTypeRapport}.{$validationColumn} = 1							
						GROUP BY 
							{$nomTypeRapport}.{$dossierColumn}";
		}

		$queryStr = implode(" UNION ", $queryArray);

		$query .= " {$queryStr}
				) AS analyse_dossier ON analyse_dossier.id_dossier_analyse = dossier.id_dossier

				LEFT JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				LEFT JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				LEFT JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse

				WHERE 					
					client_dossier = {$id_client}					
					AND type_dossier = 2					
					AND date_reception_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'									
				ORDER BY 				
					echantillon_analyse.id_echantillon_analyse";
		//echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		$echantillons = $db->loadObjectList();

		foreach ($echantillons as $echantillon) {
			$echantillon->tokenEchantillon = md5($echantillon->id_echantillon_analyse . $sharingKey);
		}

		return $echantillons;
	}



	// ======================================================================================================
	// Affiche les informations de l'échantillon et de l'annalyse
	// ======================================================================================================

	function AfficheAnalyseEchantillon($typeAnalyse, $id, $id_client)
	{
		$db = JFactory::getDBOGBMNet();

		$query = "";
		if ($typeAnalyse == "multi") {
			$query = "SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					'' as nom_qualification_analyse, 
					exo.revision AS revision, 
					exo.id AS id_analyse, 
					exo.path AS path_rapport,
					'EXOTIQUE_MULTI' AS type
				FROM
					echantillon_analyse
					JOIN dossier 					ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse 			ON client_dossier = id_client_analyse
					JOIN analyse_exotique_multi exo ON exo.id_dossier = dossier.id_dossier					
					
				WHERE 
					dossier.id_dossier = {$id}
					AND client_dossier = {$id_client}
					AND dossier.type_dossier = 2					
					AND validation = 1
					
				UNION

				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					'' as nom_qualification_analyse, 
					revision_analyse_materiau_v1_multi AS revision, 
					v1mat.id_analyse_materiau_v1_multi AS id_analyse, 
					v1mat.path_pdf_analyse_materiau_v1_multi AS path_rapport,
					'MATERIAU' AS type
				FROM
					echantillon_analyse
					JOIN dossier 							ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse 					ON client_dossier = id_client_analyse
					JOIN analyse_materiau_v1_multi v1mat 	ON v1mat.dossier_analyse_materiau_v1_multi = dossier.id_dossier
					
				WHERE 
					dossier.id_dossier = {$id}
					AND client_dossier = {$id_client}
					AND dossier.type_dossier = 2					
					AND validation_analyse_materiau_v1_multi = 1

				ORDER BY revision DESC";
		}

		if ($typeAnalyse == "mono") {
			$query = "SELECT echantillon_analyse.*, dossier.*, nom_client_analyse, nom_qualification_analyse, revision_analyse_meta_1 as revision, id_analyse_meta_1 as id_analyse, '' AS path_rapport, 'META' as type
				FROM echantillon_analyse, dossier, analyse_meta_1, client_analyse, type_prelevement, qualification_analyse
				WHERE id_echantillon_analyse = {$id}
				AND dossier_echantillon_analyse = id_dossier
				AND client_dossier = {$id_client}
				AND type_dossier = 2
				AND id_client_analyse = client_dossier
				AND id_type_prelevement = detail_echantillon_analyse
				AND qualification_analyse_type_prelevement = id_qualification_analyse
				AND echantillon_analyse_meta_1 = id_echantillon_analyse
				AND type_dossier_analyse_meta_1 = 2
				AND validation_analyse_meta_1 = 1
				
				UNION
				
				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision_analyse_meta_v0 AS revision, 
					id_analyse_meta_v0 AS id_analyse, 
					'' AS path_rapport,
					'META' AS type
				FROM 
					echantillon_analyse
					JOIN dossier ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse ON client_dossier = id_client_analyse
					JOIN analyse_meta_v0 ON echantillon_analyse_meta_v0 = id_echantillon_analyse
					JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
					JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
					JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse

				WHERE 
					id_echantillon_analyse = {$id}
					AND client_dossier = {$id_client}
					AND type_dossier = 2
					AND type_dossier_analyse_meta_v0 = 2
					AND validation_analyse_meta_v0 = 1

				UNION

				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					analyse_meta_v1.revision AS revision, 
					analyse_meta_v1.id AS id_analyse, 
					analyse_meta_v1.path_rapport AS path_rapport,
					'METAv1' AS type
				FROM 
					echantillon_analyse
					JOIN dossier ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse ON client_dossier = id_client_analyse
					JOIN analyse_meta_v1 ON analyse_meta_v1.id_echantillon = echantillon_analyse.id_echantillon_analyse
					JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
					JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
					JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse

				WHERE 
					echantillon_analyse.id_echantillon_analyse = {$id}
					AND dossier.client_dossier = {$id_client}
					AND dossier.type_dossier = 2
					AND analyse_meta_v1.type_dossier = 2
					AND analyse_meta_v1.validation = 1
				
				UNION
				
				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision_analyse_mest as revision, 
					id_analyse_mest as id_analyse,
					'' AS path_rapport,
					'MEST' as type
				FROM echantillon_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN analyse_mest ON echantillon_analyse_mest = id_echantillon_analyse
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				WHERE 
					echantillon_analyse.id_echantillon_analyse = {$id}
					AND dossier.client_dossier = {$id_client}
					AND dossier.type_dossier = 2
					AND analyse_mest.type_dossier_analyse_mest = 2
					AND analyse_mest.validation_analyse_mest = 1
				
				UNION
				
				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision_analyse_materiau as revision, 
					id_analyse_materiau as id_analyse, 
					'' AS path_rapport, 
					'MATERIAU' as type
				FROM 
					echantillon_analyse, dossier, analyse_materiau, client_analyse, type_prelevement, qualification_analyse
				WHERE 
					id_echantillon_analyse = {$id}
					AND dossier_echantillon_analyse = id_dossier
					AND client_dossier = {$id_client}
					AND type_dossier = 2
					AND id_client_analyse = client_dossier
					AND id_type_prelevement = detail_echantillon_analyse
					AND qualification_analyse_type_prelevement = id_qualification_analyse
					AND echantillon_analyse_materiau = id_echantillon_analyse
					AND type_dossier_analyse_materiau = 2
					AND validation_analyse_materiau = 1
				
				UNION
				
				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision_analyse_materiau_v0 as revision, 
					id_analyse_materiau_v0 as id_analyse, 
					'' AS path_rapport, 
					'MATERIAU' as type
				FROM 
					echantillon_analyse, dossier, analyse_materiau_v0, client_analyse, type_prelevement, qualification_analyse
				WHERE 
					id_echantillon_analyse = {$id}
					AND dossier_echantillon_analyse = id_dossier
					AND client_dossier = {$id_client}
					AND type_dossier = 2
					AND id_client_analyse = client_dossier
					AND id_type_prelevement = detail_echantillon_analyse
					AND qualification_analyse_type_prelevement = id_qualification_analyse
					AND echantillon_analyse_materiau_v0 = id_echantillon_analyse
					AND type_dossier_analyse_materiau_v0 = 2
					AND validation_analyse_materiau_v0 = 1

				UNION

				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision_analyse_materiau_v1 AS revision, 
					id_analyse_materiau_v1 AS id_analyse, 
					analyse_materiau_v1.path_pdf_analyse_materiau_v1 AS path_rapport,
					'MATERIAU' AS type
				FROM 
					echantillon_analyse
					JOIN dossier ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse ON client_dossier = id_client_analyse
					JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse
					JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
					JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
					JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse

				WHERE 
					id_echantillon_analyse = {$id}
					AND client_dossier = {$id_client}
					AND type_dossier = 2
					AND type_dossier_analyse_materiau_v1 = 2
					AND validation_analyse_materiau_v1 = 1

				UNION 

				SELECT 
					echantillon_analyse.*, 
					dossier.*, 
					nom_client_analyse, 
					nom_qualification_analyse, 
					revision AS revision, 
					exo.id AS id_analyse, 
					exo.path AS path_rapport,
					'EXOTIQUE_MONO' AS type
				FROM
					echantillon_analyse
					JOIN dossier 				ON dossier_echantillon_analyse = id_dossier
					JOIN client_analyse 		ON client_dossier = id_client_analyse
					JOIN analyse_exotique exo 	ON exo.id_echantillon = echantillon_analyse.id_echantillon_analyse
					JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
					JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
					JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
					
				WHERE 
					id_echantillon_analyse = {$id}
					AND client_dossier = {$id_client}
					AND dossier.type_dossier = 2					
					AND validation = 1	

				ORDER BY revision DESC";
		}
		//echo $query;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function SearchAnalyseMateriauMulti($id_analyse, $id_echantillon)
	{
		// die("data");
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
					ref_rapport_materiau_multi as ref_rapport_multi, 
					revision_rapport_materiau_multi as revision_rapport_multi,
					validation_rapport_materiau_multi as validation_rapport_multi

				FROM 
					analyse_materiau_multi, echantillon_analyse, analyse_materiau, rapport_materiau_multi
				WHERE  
					id_analyse_materiau = " . $id_analyse . "
					and id_analyse_materiau = " . $id_echantillon . "
					and type_dossier_analyse_materiau = 2
					and analyse_materiau_multi = id_analyse_materiau
					and rapport_materiau_multi = id_rapport_materiau_multi
					and id_echantillon_analyse = echantillon_analyse_materiau
				ORDER BY 
					id_rapport_materiau_multi desc";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function SearchAnalyseMateriauMultiV0($id_analyse, $id_echantillon)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select ref_analyse_materiau_v0_multi as ref_rapport_multi, 
					revision_analyse_materiau_v0_multi as revision_rapport_multi,
					validation_analyse_materiau_v0_multi as validation_rapport_multi
				from analyse_materiau_v0_multi_link, echantillon_analyse, analyse_materiau_v0, analyse_materiau_v0_multi
				where id_analyse_materiau_v0 = " . $id_analyse . "
				and echantillon_analyse_materiau_v0 = " . $id_echantillon . "
				and type_dossier_analyse_materiau_v0 = 2
				and id_mono_analyse_materiau_v0_multi_link = id_analyse_materiau_v0
				and id_multi_analyse_materiau_v0_multi_link = id_analyse_materiau_v0_multi
				and id_echantillon_analyse = echantillon_analyse_materiau_v0
				order by id_analyse_materiau_v0_multi desc";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function SearchAnalyseMateriauMultiV1($id_analyse, $id_echantillon)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select ref_analyse_materiau_v1_multi as ref_rapport_multi, 
					revision_analyse_materiau_v1_multi as revision_rapport_multi,
					validation_analyse_materiau_v1_multi as validation_rapport_multi
				from analyse_materiau_v1_multi_link, echantillon_analyse, analyse_materiau_v1, analyse_materiau_v1_multi
				where id_analyse_materiau_v1 = " . $id_analyse . "
				and echantillon_analyse_materiau_v1 = " . $id_echantillon . "
				and type_dossier_analyse_materiau_v1 = 2
				and id_mono_analyse_materiau_v1_multi_link = id_analyse_materiau_v1
				and id_multi_analyse_materiau_v1_multi_link = id_analyse_materiau_v1_multi
				and id_echantillon_analyse = echantillon_analyse_materiau_v1
				order by id_analyse_materiau_v1_multi desc";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function SearchAnalyseHAPMulti($id_analyse)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select ref_analyse_hap_multi_rapport as ref_rapport_multi, 
					revision_analyse_hap_multi_rapport as revision_rapport_multi,
					validation_analyse_hap_multi_rapport as validation_rapport_multi
				from analyse_hap_multi, echantillon_analyse, analyse_hap, analyse_hap_multi_rapport
				where id_analyse_hap = " . $id_analyse . "
				and type_dossier_analyse_hap = 2
				and analyse_hap_multi = id_analyse_hap
				and rapport_hap_multi = id_analyse_hap_multi_rapport
				and id_echantillon_analyse = echantillon_analyse_hap
				order by id_analyse_hap_multi_rapport desc";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}


	// ======================================================================================================
	// Liste analyse META par date d'enregistrement du dossier
	// ======================================================================================================

	function ListeAnalyseMETAv0Client($id_client, $date_debut, $date_fin)
	{
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT *
				FROM echantillon_analyse
				-- JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				LEFT JOIN analyse_externe_prestation_objectif ON id_analyse_externe_prestation_objectif = objectif_echantillon_analyse 
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN analyse_meta_v0 ON echantillon_analyse_meta_v0 = id_echantillon_analyse AND type_dossier_analyse_meta_v0 = 2
				JOIN(
					SELECT MAX(revision_analyse_meta_v0) max_revision, MAX(id_analyse_meta_v0) AS max_analyse_meta_v0
					FROM analyse_meta_v0
					WHERE validation_analyse_meta_v0 = 1
					AND type_dossier_analyse_meta_v0 = 2
					GROUP BY  echantillon_analyse_meta_v0
				) AS materiau_v0 ON (materiau_v0.max_analyse_meta_v0 = analyse_meta_v0.id_analyse_meta_v0)
				JOIN analyse_meta_v0_prepa ON analyse_meta_v0_prepa = id_analyse_meta_v0
				JOIN(
					SELECT MAX(id_analyse_meta_v0_prepa) AS id_last_prepa
					FROM analyse_meta_v0_prepa
					GROUP BY analyse_meta_v0_prepa
				) AS last_prepa_meta ON (last_prepa_meta.id_last_prepa = analyse_meta_v0.id_analyse_meta_v0)
				
				WHERE fiche_analyse_echantillon_analyse = 1
				AND client_dossier = {$id_client}
				AND date_enregistrement_dossier BETWEEN '{$date_debut}' AND '{$date_fin}'
				ORDER BY id_echantillon_analyse DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function getAnalysesMetaV1Client($id_client, $date_debut, $date_fin)
	{
		$db = JFactory::getDBOGBMNet();

		$query = "SELECT 
					ech.*,
					metav1.*,
					dossier.*,
					cli.*,
					objct.nom_analyse_externe_prestation_objectif
				FROM 
					echantillon_analyse ech
				
				JOIN dossier ON dossier.id_dossier = ech.dossier_echantillon_analyse
                JOIN analyse_meta_v1 metav1 ON metav1.id_echantillon = ech.id_echantillon_analyse AND metav1.type_dossier = dossier.type_dossier
                JOIN client_analyse cli on cli.id_client_analyse = dossier.client_dossier
				JOIN(
					SELECT MAX(metav1.revision) max_revision, MAX(metav1.id) AS max_id
					FROM analyse_meta_v1 metav1
					WHERE metav1.validation = 1
					AND metav1.type_dossier = 2
					GROUP BY id_echantillon
				) AS meta_v1 ON (meta_v1.max_id = metav1.id)
				LEFT JOIN analyse_externe_prestation_objectif objct ON objct.id_analyse_externe_prestation_objectif = ech.objectif_echantillon_analyse 
              
				WHERE 
                    dossier.type_dossier = 2
					AND metav1.validation = 1
					AND client_dossier = {$id_client}
					AND date_enregistrement_dossier 
						BETWEEN '{$date_debut}' AND '{$date_fin}'
				ORDER BY 
					id_echantillon_analyse DESC";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}



	// ======================================================================================================
	// Liste analyse Materiau par date d'enregistrement du dossier
	// ======================================================================================================

	function ListeAnalyseMateriauV0Date($id_client, $debut, $fin)
	{
		$date_debut = $debut . " 00:00:00";
		$date_fin = $fin . " 23:59:59";

		$db = JFactory::getDBOGBMNet();
		$query = "Select *
				from echantillon_analyse
				JOIN type_prelevement ON detail_echantillon_analyse = id_type_prelevement
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN analyse_materiau_v0 ON echantillon_analyse_materiau_v0 = id_echantillon_analyse and type_dossier_analyse_materiau_v0 = 2
				JOIN(
					SELECT MAX(revision_analyse_materiau_v0) max_revision, MAX(id_analyse_materiau_v0) as max_analyse_materiau_v0
					FROM analyse_materiau_v0
					WHERE validation_analyse_materiau_v0 = 1
					and type_dossier_analyse_materiau_v0 = 2
					GROUP BY  echantillon_analyse_materiau_v0
				) as materiau_v0 ON (materiau_v0.max_analyse_materiau_v0 = analyse_materiau_v0.id_analyse_materiau_v0)
				
				where fiche_analyse_echantillon_analyse = 1
				and client_dossier = " . $id_client . "
				and date_enregistrement_dossier between '" . $date_debut . "' and '" . $date_fin . "'";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauV1Date($id_client, $debut, $fin)
	{
		$date_debut = $debut . " 00:00:00";
		$date_fin = $fin . " 23:59:59";

		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
					*
				FROM 
					echantillon_analyse
				JOIN analyse_externe_prestation_delais ON id_analyse_externe_prestation_delais = delais_prestation_echantillon_analyse
				JOIN analyse_externe_prestation ON id_analyse_externe_prestation = prestation_analyse_externe_prestation_delais
				JOIN qualification_analyse ON qualification_analyse_externe_prestation = id_qualification_analyse
				JOIN dossier ON dossier_echantillon_analyse = id_dossier
				JOIN client_analyse ON client_dossier = id_client_analyse
				JOIN analyse_materiau_v1 ON echantillon_analyse_materiau_v1 = id_echantillon_analyse and type_dossier_analyse_materiau_v1 = 2
				JOIN(
					SELECT MAX(revision_analyse_materiau_v1) max_revision, MAX(id_analyse_materiau_v1) as max_analyse_materiau_v1
					FROM analyse_materiau_v1
					WHERE validation_analyse_materiau_v1 = 1
					and type_dossier_analyse_materiau_v1 = 2
					GROUP BY  echantillon_analyse_materiau_v1
				) as materiau_v1 ON (materiau_v1.max_analyse_materiau_v1 = analyse_materiau_v1.id_analyse_materiau_v1)
				
				WHERE 
					fiche_analyse_echantillon_analyse = 1
					AND client_dossier = " . $id_client . "
					AND date_enregistrement_dossier between '" . $date_debut . "' and '" . $date_fin . "'";

		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
	function ListeAnalyseMateriauV0Couche($id_analyse)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v0_couche
			where analyse_materiau_v0_couche = " . $id_analyse;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauV0MolpCouche($id_analyse)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v0_molp_couche
			where analyse_materiau_v0_molp_couche = " . $id_analyse;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauV0MolpPrepa($id_analyse, $num_couche)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v0_molp_prepa
			where analyse_materiau_v0_molp_prepa = " . $id_analyse . "
			and num_couche_analyse_materiau_v0_molp_prepa = " . $num_couche;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauV0MetCouche($id_analyse)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v0_met_couche
			where analyse_materiau_v0_met_couche = " . $id_analyse;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeAnalyseMateriauV0MetPrepa($id_analyse, $num_couche)
	{
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
			from analyse_materiau_v0_met_prepa
			where analyse_materiau_v0_met_prepa = " . $id_analyse . "
			and num_couche_analyse_materiau_v0_met_prepa = " . $num_couche;
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheTechnicienLabo($id_technicien_labo)
	{
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


	//////////////////////////////////////////////// mes-processus ////////////////////////////////////////////////////////
	function AfficheRapportMETA269Echantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select *
		From rapport_meta_269
		where echantillon_rapport_meta_269 = " . $id_echantillon . "
		and validation_rapport_meta_269 = 1
		order by revision_rapport_meta_269 DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportMETA269V2Echantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select *
		From rapport_meta_269_v2
		where echantillon_rapport_meta_269_v2 = " . $id_echantillon . "
		and validation_rapport_meta_269_v2 = 1
		order by revision_rapport_meta_269_v2 DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheRapportMETA269V3Echantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select *
		From rapport_meta_269_v3
		where echantillon_rapport_meta_269_v3 = " . $id_echantillon . "
		and validation_rapport_meta_269_v3 = 1
		order by revision_rapport_meta_269_v3 DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseMETA1Echantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select revision_analyse_meta_1, sensibilite_analytique_analyse_meta_1, concentration_normalisee_analyse_meta_1
		From analyse_meta_1
		where echantillon_analyse_meta_1 = " . $id_echantillon . "
		and validation_analyse_meta_1 = 1
		order by revision_analyse_meta_1 DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseMETAV0Echantillon($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "
		Select id_analyse_meta_v0, revision_analyse_meta_v0, nombre_fibre_analyse_meta_v0, sa_concentration_analyse_meta_v0, concentration_normalise_concentration_analyse_meta_v0, decision_anomalie_reception_analyse_meta_v0
		From analyse_meta_v0
		where echantillon_analyse_meta_v0 = " . $id_echantillon . "
		and validation_analyse_meta_v0 = 1
		order by revision_analyse_meta_v0 DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheAnalyseMETAV1($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
			id, 
			revision, 
			nbr_fibres , 
			sa_concentration, 
			concentration_normalise , 
			'' as decision_anamolie_reception
			
		FROM 
			analyse_meta_v1
		WHERE 
			id_echantillon = " . $id_echantillon . "
			AND validation = 1
		ORDER BY 
			revision DESC
		LIMIT 1";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function AfficheStrategieProcessusMesureJ($id_echantillon_mesure_j) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT 
			*
		FROM 
			echantillon_strategie_processus AS esp

		INNER JOIN strategie_processus AS sp 	ON sp.echantillon_strategie_processus = esp.echantillon_strategie_processus
		INNER JOIN echantillon AS e 			ON sp.echantillon_strategie_processus = e.id_echantillon
		INNER JOIN presta AS p 					ON e.pose_presta_echantillon = p.id_presta
		INNER JOIN type_presta AS tp 			ON p.type_presta = tp.id_type_presta
		INNER JOIN mission AS m 				ON p.mission_presta = m.id_mission
		INNER JOIN qualification AS q 			ON tp.qualification_type_presta = q.id_qualification
		INNER JOIN duree AS d 					ON p.duree_presta = d.id_duree
		INNER JOIN detail_type_presta AS dtp 	ON p.detail_type_presta = dtp.id_detail_type_presta
		INNER JOIN methode_prelevement AS mp 	ON dtp.methode_detail_type_presta = mp.id_methode_prelevement
		INNER JOIN client AS c 					ON m.client_mission = c.id_client
		INNER JOIN chantier AS ch 				ON m.chantier_mission = ch.id_chantier
		INNER JOIN agence AS a 					ON ch.agence_chantier = a.id_agence
		WHERE 
			esp.link_echantillon_strategie_processus = " . $id_echantillon_mesure_j . "
			AND sp.validation_strategie_processus = 1
		ORDER BY 
			sp.revision_strategie_processus DESC";


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

	function ListeRapportProcessusEchantillonMETA269($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT  id_rapport_meta_269, revision_rapport_meta_269
		FROM rapport_meta_269
		WHERE echantillon_rapport_meta_269 = " . $id_echantillon . "
		AND validation_rapport_meta_269 = 1
		ORDER by revision_rapport_meta_269 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}

	function ListeRapportProcessusEchantillonMETA269V2($id_echantillon) {
		$db = JFactory::getDBOGBMNet();
		$query = "SELECT id_rapport_meta_269_v2, revision_rapport_meta_269_v2
		FROM rapport_meta_269_v2
		WHERE echantillon_rapport_meta_269_v2 = " . $id_echantillon . "
		AND validation_rapport_meta_269_v2 = 1
		ORDER by revision_rapport_meta_269_v2 desc";
		$db->setQuery($query);

		if ($db->getErrorNum()) {
			echo $db->getErrorMsg();
			exit;
		}
		return $db->loadObjectList();
	}
}

?>