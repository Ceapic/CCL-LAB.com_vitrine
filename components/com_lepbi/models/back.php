
<?php
defined('_JEXEC') or die;
class Back
{
	function GetSharingKey() {
		$config = JFactory::getConfig();
		return $config->get('sharingkey');
	}

	function CheckRemoteToken($token)
	{

		$config = JFactory::getConfig();
		$remotetoken = $config->get('remotetoken');
		// $urltemp = $remotetoken . "/index.php?option=com_lepbi&task=CheckTokenCEAPIC&token=" . $token . "&format=raw";
		//echo $urltemp;
		//die();
		return file_get_contents($remotetoken . "/index.php?option=com_lepbi&task=CheckTokenCEAPIC&token=" . $token . "&format=raw");
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
		// $db = &GBMNet::getDBOGBMNet();
		$db = JFactory::getDBOGBMNet();
		$query = "Select *
		from chantier
		join (
		select chantier_mission, date_mission
		from mission
		where client_mission = " . $id_client . "
		group by chantier_mission
		order by id_mission
		) mission ON chantier_mission = id_chantier
		where client_chantier = " . $id_client . "
		order by id_chantier desc";
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
		// $db = &GBMNet::getDBOGBMNet();
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
		// $db = &GBMNet::getDBOGBMNet();
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

	function getTypeLastStrategie($id_echantillon) {
		// $db = &GBMNet::getDBOGBMNet();
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


	function ListeRapportChantier($id_chantier) {
		// $db = &GBMNet::getDBOGBMNet();
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
		// $db = &GBMNet::getDBOGBMNet();
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

	function CheckClientEchantillon($id_client, $id_echantillon) {
		// $db = &GBMNet::getDBOGBMNet();
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

	function AfficheRapportEchantillon($id_echantillon) {
		// $db = &GBMNet::getDBOGBMNet();
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
	function ListeEchantillonChantier($id_chantier) {
		// $db = &GBMNet::getDBOGBMNet();
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


	function ListeTypeRapport($type_rapport) {
		// $db = &GBMNet::getDBOGBMNet();
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


	function AfficheLastRevisionRapport($id_echantillon, $type_rapport) {
		// $db = &GBMNet::getDBOGBMNet();
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

	function CheckClientStrategie($id_client, $id_strategie) {
		// $db = &GBMNet::getDBOGBMNet();
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


	function AfficheStrategie($id_strategie_chantier, $typeStrategie) {
		// $db = &GBMNet::getDBOGBMNet();
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
}


?>