<?php
// require_once(URL_MODELE . 'global.php');
// require_once(JPATH_COMPONENT . DS . 'models/synthese.php');
require_once(URL_MODELE . "global.php");
require_once(URL_MODELE . "strategie.php");
require_once(URL_MODELE . "synthese.php");
class StrategieChantierV1
{
    // le type de dossier pour afficheAnalyseEchantillonMEST($echantillon,TYPE_DOSSIER_INTERNE)
    const TYPE_DOSSIER_INTERNE = 1;




    const PHASE_CHANTIER_AVANT_TRAVAUX = 1;
    const PHASE_CHANTIER_PENDANT_TRAVAUX = 2;
    const PHASE_CHANTIER_APRES_TRAVAUX = 3;

    const TYPE_STRATEGIE_A = 1; // Caractérisation d’espace intérieur
    const TYPE_STRATEGIE_B = 2; // Caractérisation d’interface de travaux
    const TYPE_STRATEGIE_C = 3; // Prélèvement individuel / operateur
    const TYPE_STRATEGIE_D = 4; // Caractérisation espace extérieur

    const TYPE_EMPLACEMENT_INTERIEUR = "Intérieur";
    const TYPE_EMPLACEMENT_EXTERIEUR = "Extérieur";

    const PROTEC_PHYSIQUE_ETANCHE = "Avec protection physique étanche";
    const ID_CONTAMINATION_SUPERFICIE_INTERFACE = "6";

    const OUI = 'Oui';
    const NON = 'Non';
    const SO = 'Sans objet';
    const AUTRE = 'Autre';

    const FOURNI = 1;
    const NON_FOURNI = 2;
    const PARTIELLEMENT = 3;

    const ID_MESURE_STRATEGIE_MEST = "113"; //serv de test aussi
    const ID_MESURE_STRATEGIE_PTA = "90";

    const ID_CONTEXTE_PTE = "15";

    const IMAGE_LOCALISATION = 5;

    static function listMesureStrategie($id)
    {
        $db = &GBMNet::getDBOGBMNet();

        $query = "select * from(SELECT
            STRAT.id as id_strategie_chantier_v1,
            CONTEXTE.order_contexte_mesure_strategie as order_contexte,
            ZSE.id as id_zse,
            ZSE.reference as ref_zse,
            ZSE.nom as nom_zse,
            ZSE.phase_chantier,
            ZSE.total_pompe as total_pompe,
            null as id_zt,
            ZSE.id_zc as id_zc,
            ZSE.id_perimetre as id_perimetre,
            null as id_processus,
            null as ref_processus,
            CONTEXTE.*,
            MESURE.diminutif_mesure_strategie,
            MESURE.nom_type_mesure_strategie,
            MESURE.frequence_mesure_strategie as frequence,
            MESURE.duree_presta_mesure_strategie as duree,
            MESURE.pose_recup_mesure_strategie as pr,
            MESURE.couleur_mesure_strategie as couleur,
            DTP.id_detail_type_presta as detail_type_presta,
            TP.id_type_presta as type_presta,
            QUAL.id_qualification as categorie,
            ZC.reference as ref_zc,
            ZC.nom as nom_zc,
            PI.reference as ref_pi,
            PI.nom as nom_pi,
            IF(ZSE.id_perimetre is NULL ,
                ZSE.id_zc,
                ZSE.id_perimetre
            ) AS id_zone,
            IF(ZSE.id_perimetre is NULL ,
                'ZC',
                'PI'
            ) AS type_zone,
            IF(ZSE.id_perimetre is NULL ,
                CONCAT (ZC.reference, IF(ZC.nom = '', '', CONCAT(' - ', ZC.nom))),
                CONCAT (PI.reference, IF(PI.nom = '', '', CONCAT(' - ', PI.nom)))
            ) AS nom_zone
        FROM
            strategie_chantier_v1 STRAT
        JOIN strategie_chantier_v1_zse ZSE ON zse.id_strategie_chantier_v1 = STRAT.id
        JOIN mesure_strategie MESURE ON MESURE.id_mesure_strategie = ZSE.id_mesure_strategie
        JOIN contexte_mesure_strategie CONTEXTE ON CONTEXTE.id_contexte_mesure_strategie = MESURE.contexte_mesure_strategie
        JOIN detail_type_presta DTP ON DTP.id_detail_type_presta = MESURE.detail_type_presta_mesure_strategie
        JOIN type_presta TP ON TP.id_type_presta = DTP.type_presta_detail_type_presta
        JOIN qualification QUAL ON QUAL.id_qualification = TP.qualification_type_presta
        LEFT JOIN strategie_chantier_v1_zone_chantier ZC ON ZC.id = ZSE.id_zc
        LEFT JOIN strategie_chantier_v1_perimetre_investigation PI ON PI.id = ZSE.id_perimetre
        WHERE
            strat.id = {$id}
        UNION ALL
        SELECT
            STRAT.id as id_strategie_chantier_v1,
            CONTEXTE.order_contexte_mesure_strategie as order_contexte,
            null as id_zse,
            ZT.reference as ref_zse,
            null as nom_zse,
            null as phase_chantier,
            1 as total_pompe,
            MESURE_HS.id_zt as id_zt,
            ZC.id as id_zc,
            null as id_perimetre,
            MESURE_HS.id_processus as id_processus,
            PROCESSUS.reference_client as ref_processus,
            CONTEXTE.*,
            MESURE.diminutif_mesure_strategie,
            MESURE.nom_type_mesure_strategie,
            MESURE.frequence_mesure_strategie as frequence,
            MESURE.duree_presta_mesure_strategie as duree,
            MESURE.pose_recup_mesure_strategie as pr,
            MESURE.couleur_mesure_strategie as couleur,
            DTP.id_detail_type_presta as detail_type_presta,
            TP.id_type_presta as type_presta,
            QUAL.id_qualification as categorie,
            ZC.reference as ref_zc,
            ZC.nom as nom_zc,
            null as ref_pi,
            null as nom_pi,
            ZC.id   AS id_zone,
            'ZC'    AS type_zone,
            CONCAT (ZC.reference, IF(ZC.nom = '', '', CONCAT(' - ', ZC.nom))) AS nom_zone
        FROM
            strategie_chantier_v1 STRAT
        JOIN strategie_chantier_v1_mesure_hors_strategie MESURE_HS ON MESURE_HS.id_strategie_chantier_v1 = STRAT.id
        LEFT JOIN processus_client PROCESSUS ON PROCESSUS.id = MESURE_HS.id_processus
        JOIN mesure_strategie MESURE ON MESURE.id_mesure_strategie = MESURE_HS.id_mesure_strategie
        JOIN contexte_mesure_strategie CONTEXTE ON CONTEXTE.id_contexte_mesure_strategie = MESURE.contexte_mesure_strategie
        JOIN detail_type_presta DTP ON DTP.id_detail_type_presta = MESURE.detail_type_presta_mesure_strategie
        JOIN type_presta TP ON TP.id_type_presta = DTP.type_presta_detail_type_presta
        JOIN qualification QUAL ON QUAL.id_qualification = TP.qualification_type_presta
        LEFT JOIN strategie_chantier_v1_zone_chantier_detail ZC_DETAIL ON ZC_DETAIL.id = MESURE_HS.id_zcdetail
        LEFT JOIN strategie_chantier_v1_zone_travail ZT ON ZT.id = MESURE_HS.id_zt
        LEFT JOIN strategie_chantier_v1_zone_chantier_zt ZC_ZT ON ZC_ZT.id_zone_travail = ZT.id
        LEFT JOIN strategie_chantier_v1_zone_chantier ZC ON (ZC.id = ZC_ZT.id_zone_chantier OR ZC.id = ZC_DETAIL.id_zc)
        WHERE
            strat.id = {$id}) as test
       ORDER BY
            test.order_contexte,
            test.ref_zse

            ";

        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function listMesureEchantillonStrategie($idStrategieChantierV1)
    {
        $db = &GBMNet::getDBOGBMNet();

        $req = "SELECT
               if(zc.id is null,pi.id,zc.id) as id_zone, 
               if(zc.id is null,'PI','ZC') as type_zone,
               if(zc.id is null,pi.nom,zc.nom) as nom_zone,
               0 as test
            FROM 
                strategie_chantier_v1_pompe p            
            JOIN strategie_chantier_v1_zse zse  ON zse.id = p.id_entite

            LEFT JOIN strategie_chantier_v1_perimetre_investigation pi  ON pi.id = zse.id_perimetre
            LEFT JOIN strategie_chantier_v1_zone_chantier zc            ON zc.id = zse.id_zc

            WHERE
                p.id_strategie_chantier_v1 = {$idStrategieChantierV1}
        
        ";
        $db->setQuery($req);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function listStrategieEchantillon($id)
    {
        $db = &GBMNet::getDBOGBMNet();

        $query = "SELECT                
                if(ZSE.id_perimetre is NULL, 
                    STRAT_ECH.id_zc,
                    ZSE.id_perimetre) as id_zone,
                  IF(ZSE.id_perimetre is NULL, 
                        'ZC',
                        'PI'
                    ) AS type_zone,
                IFNULL(CONTEXTE.id_contexte_mesure_strategie,CONTEXTE2.id_contexte_mesure_strategie) as id_contexte,
                IFNULL(CONTEXTE.nom_contexte_mesure_strategie,CONTEXTE2.nom_contexte_mesure_strategie) as contexte,
                ZSE.id as id_zse,
                ECH.id_echantillon, 
                ECH.ref_echantillon, 
                CONCAT( 
                    dtp.nom_detail_type_presta,
                    ' ',
                    IF(pc.id is not NULL, CONCAT(' (Processus : ',pc.reference_client,')'), '')
                    )as type_mesure, 
                IFNULL(MESURE.id_mesure_strategie,MESURE2.id_mesure_strategie) as id_mesure,
                DATE_FORMAT(mission.date_mission,'%d/%m/%Y') as date_pose,                
                v1.revision as rev_strat                
                
            FROM 
                strategie_chantier_v1_echantillon as STRAT_ECH
            JOIN strategie_chantier_v1 v1                   ON v1.id = STRAT_ECH.id_strategie_chantier_v1
            LEFT JOIN strategie_chantier_v1_pompe p         ON p.id = STRAT_ECH.id_pompe_origine    

            LEFT JOIN strategie_chantier_v1_zse ZSE         ON ZSE.id = STRAT_ECH.id_zse
            LEFT JOIN mesure_strategie MESURE               ON MESURE.id_mesure_strategie = ZSE.id_mesure_strategie
            LEFT JOIN contexte_mesure_strategie CONTEXTE    ON CONTEXTE.id_contexte_mesure_strategie = MESURE.contexte_mesure_strategie             
            
            JOIN echantillon ECH                            ON ECH.id_echantillon = STRAT_ECH.id_echantillon
            LEFT JOIN presta                                ON presta.id_presta = ech.pose_presta_echantillon   
            LEFT JOIN mission                               ON mission.id_mission = presta.mission_presta   
            LEFT JOIN detail_type_presta dtp                ON dtp.id_detail_type_presta = presta.detail_type_presta   
            LEFT JOIN mesure_strategie MESURE2              ON MESURE2.detail_type_presta_mesure_strategie = dtp.id_detail_type_presta AND MESURE2.disable_mesure_strategie = 0
            LEFT JOIN contexte_mesure_strategie CONTEXTE2   ON CONTEXTE2.id_contexte_mesure_strategie = MESURE2.contexte_mesure_strategie  

            LEFT JOIN echantillon_strategie_processus esp   ON esp.link_echantillon_strategie_processus = STRAT_ECH.id_echantillon  
            LEFT JOIN processus_client pc                   ON pc.id = esp.processus_client_echantillon_strategie_processus        
          
            WHERE 
                STRAT_ECH.id_strategie_chantier_v1 = {$id}   
            ";


        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $resultats = $db->loadObjectList();

        return $resultats;
    }

    static function getIdMissionsFromStratV1($idStrategie)
    {
        $db = &GBMNet::getDBOGBMNet();

        $req = "SELECT
                mission.id_mission
            FROM 
                strategie_chantier_v1_mesure_hors_strategie as STRAT_ECH
            INNER JOIN mesure_strategie ms                          ON ms.id_mesure_strategie = STRAT_ECH.id_mesure_strategie
            INNER JOIN strategie_chantier_v1_echantillon v1_ech     ON v1_ech.id_strategie_chantier_v1 = STRAT_ECH.id_strategie_chantier_v1
            INNER JOIN echantillon ech                              ON ech.id_echantillon = v1_ech.id_echantillon
            INNER JOIN presta                                       ON presta.id_presta = ech.pose_presta_echantillon   
            INNER JOIN mission                                      ON mission.id_mission = presta.mission_presta             
            
            WHERE
                STRAT_ECH.id_strategie_chantier_v1 = {$idStrategie}
                
            GROUP BY
                mission.id_mission
            ";

        $db->setQuery($req);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function getEchantillonMESTByidMissionAndIdStratV1($idMission, $idStrategie)
    {
        $db = &GBMNet::getDBOGBMNet();

        echo "hello3";
        die();

        $req = "SELECT
                ZC.id as id_zone,
                'ZC' AS type_zone,
                0 as id_zse,
                ech.id_echantillon, 
                ech.ref_echantillon, 
                CONCAT(ms.diminutif_mesure_strategie, ' - ',ms.nom_type_mesure_strategie) as type_mesure, 
                DATE_FORMAT(mission.date_mission,'%d/%m/%Y') as date_pose,                
                0 as rev_strat 
                
            FROM 
                echantillon ech
            INNER JOIN presta                                           ON presta.id_presta = ech.pose_presta_echantillon
            INNER JOIN mission                                          ON mission.id_mission = presta.mission_presta
            INNER JOIN strategie_chantier_v1_mesure_hors_strategie mhs  ON mhs.id_strategie_chantier_v1 = {$idStrategie} AND mhs.id_processus IS NULL
            INNER JOIN mesure_strategie ms                              ON ms.id_mesure_strategie = mhs.id_mesure_strategie

            INNER JOIN strategie_chantier_v1_zone_chantier_detail ZCD   ON ZCD.id = mhs.id_zcdetail
            LEFT JOIN strategie_chantier_v1_zone_chantier ZC            ON ZC.id = ZCD.id_zc

            WHERE 
                presta.mission_presta = {$idMission}
                AND presta.detail_type_presta = ms.detail_type_presta_mesure_strategie            
            GROUP BY 
                id_zone,
                ech.id_echantillon
        ";

        $db->setQuery($req);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }


    static function listeRFM($idStrategie)

    {
        $db = &GBMNet::getDBOGBMNet();

        $query = "SELECT                
                if(ZSE.id_perimetre is NULL, 
                    STRAT_ECH.id_zc,
                    ZSE.id_perimetre) as id_zone,
                  IF(ZSE.id_perimetre is NULL, 
                        'ZC',
                        'PI'
                    ) AS type_zone,
                STRAT_ECH.id_zse as id_zse,
                rfm.id, 
                rfm.reference, 
                rfm.id_mission,
                IFNULL(ms.contexte_mesure_strategie," . StrategieChantierV1::ID_CONTEXTE_PTE . ") as id_contexte, 
                'Rapport Final' as type_mesure, 
                DATE_FORMAT(rfm.date_validation,'%d/%m/%Y') as date_rapport,                
                rfm.revision
                
            FROM 
                strategie_chantier_v1_echantillon as STRAT_ECH
            
            JOIN strategie_chantier_v1 v1           ON v1.id = STRAT_ECH.id_strategie_chantier_v1
            LEFT JOIN strategie_chantier_v1_zse ZSE ON ZSE.id = STRAT_ECH.id_zse
            LEFT JOIN mesure_strategie ms           ON ms.id_mesure_strategie = ZSE.id_mesure_strategie
            JOIN echantillon ECH                    ON ECH.id_echantillon = STRAT_ECH.id_echantillon
            JOIN presta                             ON presta.id_presta = ech.pose_presta_echantillon   
            JOIN mission                            ON mission.id_mission = presta.mission_presta   
            JOIN rapport_final_mission rfm          ON rfm.id_mission = mission.id_mission                
           
            WHERE 
                STRAT_ECH.id_strategie_chantier_v1 = {$idStrategie} 
                AND rfm.validation = 1
                
            GROUP BY 
                id_zone,
                type_zone
                ";

        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function listStrategieEchantillonCorbeille($id)
    {
        $db = &GBMNet::getDBOGBMNet();


        $query = "SELECT                
                if(ZSE.id_perimetre is NULL, 
                    STRAT_ECH.id_zc,
                    ZSE.id_perimetre) as id_zone,
                  IF(ZSE.id_perimetre is NULL , 
                        'PI',
                        'ZC'
                    ) AS type_zone,
                ECH.id_zse_corbeille_echantillon as id_zse,
                ms.contexte_mesure_strategie as id_contexte,
                dtp.nom_detail_type_presta as type_mesure, 
                DATE_FORMAT(ECH.date_mission_corbeille_echantillon,'%d/%m/%Y') as date_mission,                
                DATE_FORMAT(ECH.date_creation_corbeille_echantillon,'%d/%m/%Y') as date_suppression,                
                ECH.commentaire_corbeille_echantillon as commentaire


             FROM 
                strategie_chantier_v1_echantillon as STRAT_ECH
            JOIN corbeille_echantillon ECH          ON ECH.id_corbeille_echantillon = STRAT_ECH.id_echantillon
            JOIN strategie_chantier_v1 v1           ON v1.id = STRAT_ECH.id_strategie_chantier_v1                       
            LEFT JOIN strategie_chantier_v1_zse ZSE ON ZSE.id = ECH.id_zse_corbeille_echantillon
            LEFT JOIN mesure_strategie ms           ON ms.id_mesure_strategie = ZSE.id_mesure_strategie
            LEFT JOIN mission                       ON mission.id_mission = ECH.id_mission_corbeille_echantillon   
            LEFT JOIN detail_type_presta dtp        ON dtp.id_detail_type_presta = ECH.detail_type_corbeille_echantillon         

            WHERE 
                STRAT_ECH.id_strategie_chantier_v1 = {$id}
        ";

        /* REQ TEST AFFICHAGE
        $query = "SELECT                
                    407 as id_zone,
                    'ZC' as type_zone,
                    ECH.id_zse_corbeille_echantillon as id_zse,                        
                    dtp.nom_detail_type_presta as type_mesure, 
                    DATE_FORMAT(ECH.date_mission_corbeille_echantillon,'%d-%m-%Y') as date_mission,                
                    DATE_FORMAT(ECH.date_creation_corbeille_echantillon,'%d-%m-%Y') as date_suppression,                
                    ECH.commentaire_corbeille_echantillon as commentaire
                    
                    
                FROM 
                   corbeille_echantillon ECH                         
                LEFT JOIN strategie_chantier_v1_zse ZSE ON ZSE.id = ECH.id_zse_corbeille_echantillon
                LEFT JOIN mission                       ON mission.id_mission = ECH.id_mission_corbeille_echantillon   
                LEFT JOIN detail_type_presta dtp        ON dtp.id_detail_type_presta = ECH.detail_type_corbeille_echantillon         

                WHERE 
                    ECH.id_corbeille_echantillon in (62100,62101)
            ";*/

        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    //MANQUE A DEDUIRE QTE MEST DEJA FAITES PAR ZONE
    //PRIS EN COMPTE DANS L'AFFICHAGE 
    //MAIS JE PENSE QU'IL FAUDRA LE CHANGER POUR METTRE UN LIEN ENTRE v1_echantillon et les MESURE_HS
    //POUR AVOIR UNE QUANTITE RESTANTE A FAIRE AVEC UNE REQUETE DE CE TYPE
    static function listStrategieEchantillonNonCommande($idStrategieChantierV1)
    {
        $db = &GBMNet::getDBOGBMNet();

        $reqMesure = "SELECT
                zse.id as id_zse,
                if(zc.id is NULL,pi.id,zc.id) as id_zone, 
                if(zc.id is NULL,'PI','ZC') as type_zone,
                if(zc.id is NULL,pi.nom,zc.nom) as nom_zone,
                c.id_contexte_mesure_strategie as id_contexte,
                CONCAT(ms.diminutif_mesure_strategie,' : ',ms.nom_type_mesure_strategie) as type_mesure,
                0 as isMest,
                0 as idPta,
                COUNT(*) as quantite
            FROM 
                strategie_chantier_v1_pompe p            
            JOIN strategie_chantier_v1_zse zse  ON zse.id = p.id_entite
            JOIN mesure_strategie ms            ON ms.id_mesure_strategie = zse.id_mesure_strategie
            JOIN contexte_mesure_strategie c    ON c.id_contexte_mesure_strategie = ms.contexte_mesure_strategie

            LEFT JOIN strategie_chantier_v1_echantillon v1_ech          ON v1_ech.id_pompe_origine = p.id
            LEFT JOIN strategie_chantier_v1_perimetre_investigation pi  ON pi.id = zse.id_perimetre
            LEFT JOIN strategie_chantier_v1_zone_chantier zc            ON zc.id = zse.id_zc

            WHERE
                p.id_strategie_chantier_v1 = {$idStrategieChantierV1}
                AND v1_ech.id_pompe_origine IS NULL

            GROUP BY 
                id_zse,
                id_zone,
                ms.id_mesure_strategie    

            ORDER BY 
                ms.order_mesure_strategie   
        ";

        $reqMEST = "SELECT 
                0  as id_zse,
                zc.id   as id_zone, 
                'ZC'    as type_zone,
                zc.nom  as nom_zone,
                c.id_contexte_mesure_strategie as id_contexte,
                CONCAT(ms.diminutif_mesure_strategie,' : ',ms.nom_type_mesure_strategie) as type_mesure,
                1 as isMest,       
                0 as isPta,         
                COUNT(*) as quantite
            FROM 
                strategie_chantier_v1_mesure_hors_strategie MESURE_HS
            
            INNER JOIN strategie_chantier_v1_zone_chantier_detail zcd   ON zcd.id = MESURE_HS.id_zcdetail
            LEFT JOIN strategie_chantier_v1_zone_chantier zc            ON zc.id = zcd.id_zc
            INNER JOIN mesure_strategie ms                              ON ms.id_mesure_strategie = MESURE_HS.id_mesure_strategie
            INNER JOIN contexte_mesure_strategie c                      ON c.id_contexte_mesure_strategie = ms.contexte_mesure_strategie                           
                
            WHERE 
                MESURE_HS.id_processus is NULL
                AND MESURE_HS.id_strategie_chantier_v1 = {$idStrategieChantierV1}

            GROUP BY 
                id_zone,
                ms.id_mesure_strategie";

        $reqProcessus = "SELECT 
                0       as id_zse,
                zc.id   as id_zone, 
                'ZC'    as type_zone,
                zc.nom  as nom_zone,
                c.id_contexte_mesure_strategie as id_contexte,
                CONCAT(ms.diminutif_mesure_strategie,' : ',ms.nom_type_mesure_strategie,' (Processus: ',IFNULL(pc.reference_client,''),')') as type_mesure,
                0       as isMest,  
                1       as isPta,              
                COUNT(*) as quantite
            FROM 
                strategie_chantier_v1_mesure_hors_strategie MESURE_HS
            
            INNER JOIN strategie_chantier_v1_zone_travail zt            ON zt.id = MESURE_HS.id_zt            
            INNER JOIN strategie_chantier_v1_zone_chantier_zt ZC_ZT     ON ZC_ZT.id_zone_travail = ZT.id
            INNER JOIN strategie_chantier_v1_zone_chantier zc           ON zc.id = ZC_ZT.id_zone_chantier
            INNER JOIN mesure_strategie ms                              ON ms.id_mesure_strategie = MESURE_HS.id_mesure_strategie
            INNER JOIN contexte_mesure_strategie c                      ON c.id_contexte_mesure_strategie = ms.contexte_mesure_strategie 
            LEFT JOIN processus_client pc                               ON pc.id = MESURE_HS.id_processus                          
                
            WHERE 
                MESURE_HS.id_processus is not NULL
                AND MESURE_HS.id_strategie_chantier_v1 = {$idStrategieChantierV1}

            GROUP BY 
                id_zone,
                ms.id_mesure_strategie, 
                pc.id ";


        $reqTotale = "({$reqMesure}) UNION ALL ({$reqMEST}) UNION ALL ({$reqProcessus})";


        $db->setQuery($reqTotale);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function listStrategieEchantillonRecap($idStrategieChantierV1)
    {
        $db = &GBMNet::getDBOGBMNet();

        $reqEch = "SELECT
                zse.id as id_zse,
                if(zc.id is NULL,pi.id,zc.id) as id_zone, 
                if(zc.id is NULL,'PI','ZC') as type_zone,
                if(zc.id is NULL,CONCAT(pi.reference,' - ',pi.nom),CONCAT(ZC.reference,' - ',zc.nom)) as nom_zone,
                CONCAT(zse.reference,' - ',zse.nom) as nom_zse_zt,
                CONCAT(ms.diminutif_mesure_strategie,' : ',ms.nom_type_mesure_strategie) as type_mesure,
                ms.contexte_mesure_strategie as id_contexte,
                ms.couleur_mesure_strategie as couleur_mesure,
                COUNT(*) as quantite_totale,
                SUM(if(v1_ech.id_pompe_origine IS NULL,0,1)) as quantite_realise
            FROM 
                strategie_chantier_v1_pompe p            
            JOIN strategie_chantier_v1_zse zse  ON zse.id = p.id_entite
            JOIN mesure_strategie ms            ON ms.id_mesure_strategie = zse.id_mesure_strategie

            LEFT JOIN strategie_chantier_v1_echantillon v1_ech          ON v1_ech.id_pompe_origine = p.id
            LEFT JOIN strategie_chantier_v1_perimetre_investigation pi  ON pi.id = zse.id_perimetre
            LEFT JOIN strategie_chantier_v1_zone_chantier zc            ON zc.id = zse.id_zc

            WHERE
                p.id_strategie_chantier_v1 = {$idStrategieChantierV1}                

            GROUP BY 
                id_zse,
                id_zone,
                ms.id_mesure_strategie             

            ORDER BY 
                ms.order_mesure_strategie   
        ";

        $reqMEST =  "SELECT 
                0 as id_zse,
                zc.id as id_zone, 
                'ZC' as type_zone,
                CONCAT(ZC.reference,' - ',ZC.nom) as nom_zone,
                CONCAT(ZT.reference,' - ',ZT.nom) as nom_zse_zt,
                CONCAT(MESURE.diminutif_mesure_strategie,' : ',MESURE.nom_type_mesure_strategie) as type_mesure,
                MESURE.contexte_mesure_strategie as id_contexte,
                MESURE.couleur_mesure_strategie as couleur_mesure,
                COUNT(*) as quantite_totale,
                -- SUM(if(v1_ech.id_pompe_origine IS NULL,0,1)) as quantite_realise A VOIR COMMENT ALLER LE CHERCHER
                0 as quantite_realise
            
            FROM 
                strategie_chantier_v1 STRAT
            JOIN strategie_chantier_v1_mesure_hors_strategie MESURE_HS      ON MESURE_HS.id_strategie_chantier_v1 = STRAT.id
            JOIN mesure_strategie MESURE                                    ON MESURE.id_mesure_strategie = MESURE_HS.id_mesure_strategie      
            JOIN strategie_chantier_v1_zone_chantier_detail ZC_DETAIL       ON ZC_DETAIL.id = MESURE_HS.id_zcdetail
            JOIN strategie_chantier_v1_zone_chantier ZC                     ON ZC.id = ZC_detail.id_zc
            LEFT JOIN strategie_chantier_v1_zone_travail ZT                 ON ZT.id = MESURE_HS.id_zt
            LEFT JOIN strategie_chantier_v1_zone_chantier_zt ZC_ZT          ON ZC_ZT.id_zone_travail = ZT.id
            
            WHERE 
                strat.id = {$idStrategieChantierV1}
                AND MESURE_HS.id_processus is NULL 
            GROUP BY 
                id_zone,
                MESURE_HS.id_mesure_strategie    
            ";

        $reqTotale = "({$reqEch}) UNION ALL ({$reqMEST})";

        $db->setQuery($reqTotale);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function getProcessusClient($idClient)
    {
        $db = &GBMNet::getDBOGBMNet();

        $req = "SELECT 
                pc.*, 
                GROUP_CONCAT(pt.id)             AS idTechniques, 
                GROUP_CONCAT(pt.nom)            AS nomTechniques,
                GROUP_CONCAT(mmm.id)            AS idMateriaux,
                GROUP_CONCAT(mmm.nom)           AS nomMateriaux, 
                pt.type                         AS typeTechnique,
                REPLACE(pc.protection_humidification,'\"','')    AS protectionHumidification,
                REPLACE(pc.protection_captage,'\"','')           AS protectionCaptage

            FROM
                processus_client pc              
            INNER JOIN processus_client_technique pct   ON pct.id_processus_client = pc.id
            INNER JOIN processus_technique pt           ON pt.id = pct.id_processus_technique
            INNER JOIN processus_client_mpca pcm        ON pcm.id_processus_client = pc.id
            INNER JOIN mpca_matrice_materiau mmm        ON mmm.id = pcm.id_mpca_materiau
            
            WHERE
                pc.id_client=" . $idClient . "
                
            GROUP BY 
                pc.id
            ORDER BY    
                id";
        $db->setQuery($req);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $datas = $db->loadObjectList();

        foreach ($datas as $data) {
            $data->protection = explode(",", str_replace(['[', ']'], '', Tools::decodeCaracteres($data->protectionHumidification)));
            $data->captage = explode(",", str_replace(['[', ']'], '', Tools::decodeCaracteres($data->protectionCaptage)));
        }
        return $datas;
    }

    static function listStrategieEchantillonRecapProcessus($idStrategieChantierV1)
    {
        $db = &GBMNet::getDBOGBMNet();

        $reqProcessus = "SELECT 
                0 as id_zse,
                zc.id as id_zone, 
                'ZC' as type_zone,
                CONCAT(ZC.reference,' - ',ZC.nom) as nom_zone,
                CONCAT(ZT.reference,' - ',ZT.nom) as nom_zse_zt,
                CONCAT(MESURE.diminutif_mesure_strategie,' : ',MESURE.nom_type_mesure_strategie,' (Processus :',IFNULL(pc.reference_client,''), ')') as type_mesure,
                MESURE.contexte_mesure_strategie as id_contexte,
                MESURE.couleur_mesure_strategie as couleur_mesure,
                pc.id as id_processus,
                MESURE_HS.id as id_mhs,
                COUNT(*) as quantite_totale,
                -- SUM(if(v1_ech.id_pompe_origine IS NULL,0,1)) as quantite_realise A VOIR COMMENT ALLER LE CHERCHER
                0 as quantite_realise
            
            FROM 
                strategie_chantier_v1 STRAT
            JOIN strategie_chantier_v1_mesure_hors_strategie MESURE_HS      ON MESURE_HS.id_strategie_chantier_v1 = STRAT.id
            JOIN mesure_strategie MESURE                                    ON MESURE.id_mesure_strategie = MESURE_HS.id_mesure_strategie      
            JOIN strategie_chantier_v1_zone_travail ZT                      ON ZT.id = MESURE_HS.id_zt
            JOIN strategie_chantier_v1_zone_chantier_zt ZC_ZT               ON ZC_ZT.id_zone_travail = ZT.id
            JOIN strategie_chantier_v1_zone_chantier ZC                     ON ZC.id = ZC_ZT.id_zone_chantier
            LEFT JOIN processus_client pc                                   ON pc.id = MESURE_HS.id_processus
            
            WHERE 
                strat.id = {$idStrategieChantierV1}
                AND MESURE_HS.id_processus is not NULL 
            GROUP BY 
                id_zone, 
                MESURE_HS.id_mesure_strategie, 
                pc.id
                ";

        $db->setQuery($reqProcessus);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }


    static function getResultatAndCofrac($idEchantillon)
    {

        $resultat = "En cours de traitement";
        $cofrac = "";

        $modelStrategie  = new Strategie();
        $modelSynthese = new Synthese();

        $typeRapport = $modelStrategie->AfficheTypeRapport($idEchantillon)->type;

        if ($typeRapport == "META050" || $typeRapport == "META269v3") {
            $Analyses = $modelSynthese->getAnalysesEchantillonMETAv1($idEchantillon, 1);
            if (count($Analyses) != 0) {
                $oneAnalyse = $Analyses[0];
                $resultat = number_format($oneAnalyse->concentration_normalise, 1, ",", "");
                $nombre_fibre = str_replace(".", ",", $oneAnalyse->nbr_fibres);
                if ($nombre_fibre < 4) {
                    $resultat = "&lt;" . $resultat;
                }
                if ($oneAnalyse->cofrac == 1) {
                    $cofrac = "*";
                }
            }
        }

        if ($typeRapport == "MEST") {
            $AfficheRapport_Analyse = $modelSynthese->AfficheAnalyseEchantillonMEST($idEchantillon, StrategieChantierV1::TYPE_DOSSIER_INTERNE);
            $AfficheRapport = $modelSynthese->AfficheRapportEchantillonMEST($idEchantillon);

            // Analyses mest
            if (count($AfficheRapport_Analyse) != 0) {
                $resultat = $AfficheRapport_Analyse[0]->ph_analyse_mest;
                $Concentration = round((((str_replace(",", ".", $AfficheRapport_Analyse[0]->masse_filtre_pese_finale_analyse_mest) - str_replace(",", ".", $AfficheRapport_Analyse[0]->masse_filtre_pese_initiale_analyse_mest)) * 1000) / str_replace(",", ".", $AfficheRapport_Analyse[0]->volume_liquide_filtration_analyse_mest)), 1);
                if ($Concentration <= 5) {
                    $Concentration = "&lt; 5";
                } else {
                    $Concentration = number_format($Concentration, 1, ".", "");
                }
                $resultat = "pH " . $resultat . " - C: " . $Concentration . "mg/L";
                if ($AfficheRapport_Analyse[0]->cofrac_rapport_mest == 1) {
                    $cofrac = "*";
                }
                //rapport mest
            } else if (count($AfficheRapport) != 0) {

                $resultat = $AfficheRapport[0]->ph_rapport_mest;
                $Concentration = round((((str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_finale_rapport_mest) - str_replace(",", ".", $AfficheRapport[0]->masse_filtre_pese_initiale_rapport_mest)) * 1000) / str_replace(",", ".", $AfficheRapport[0]->volume_liquide_filtration_rapport_mest)), 1);
                if ($Concentration <= 5) {
                    $Concentration = "&lt; 5";
                } else {
                    $Concentration = number_format($Concentration, 1, ".", "");
                }
                $resultat = "pH " . $resultat . " - C: " . $Concentration . "mg/L";
                if ($AfficheRapport[0]->cofrac_rapport_mest == 1) {
                    $cofrac = "*";
                }
            }
            else{
                die("error");
            }
        }

        return [$resultat, $cofrac];
    }
}
