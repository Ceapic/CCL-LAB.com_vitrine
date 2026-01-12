<?php

defined('_JEXEC') or die('Acces interdit');

jimport('joomla.application.component.model');

class RapportModel {

    #region Type rapport
    const TYPE_RAPPORT_PRLV = 1;
    const TYPE_RAPPORT_ANALYSE = 2;
    const TYPE_RAPPORT_STRAT_CHANTIER = 3;
    const TYPE_RAPPORT_STRAT_PROCESSUS = 4;

    #endregion
    const TYPE_RAPPORT_MEST       = 'rapport_mest';
    const TYPE_RAPPORT_META_050   = 'rapport_meta_050';
    const TYPE_RAPPORT_MATERIAU   = 'rapport_materiau';
    const TYPE_RAPPORT_META_269V3 = 'rapport_meta_269_v3';


    static function getTypeRapportByType($type_rapport) {
        $db = JFactory::getDBOGBMNet();
        $query = "SELECT * FROM type_rapport WHERE type_rapport = {$type_rapport}";
        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function getTypeRapportByTypeAndMulti($type_rapport, $isMulti) {
        $db = JFactory::getDBOGBMNet();
        $query = "SELECT * FROM type_rapport WHERE type_rapport = {$type_rapport} and is_multi_type_rapport = {$isMulti}";
        // echo $query;
        $db->setQuery($query);

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        return $db->loadObjectList();
    }

    static function getAnalyse($id_echantillon, $description = "") {
        $db = JFactory::getDBOGBMNet();

        $type_analyse = self::TYPE_RAPPORT_ANALYSE;
        $type_rapport = self::getTypeRapportByType($type_analyse);
        $result = [];

        foreach ($type_rapport as $oneTypeRapport) {
            $nomTypeRapport = $oneTypeRapport->nom_type_rapport;
            $shortNameColumn = $oneTypeRapport->type_colonne_name;

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
                $echantillonColumn = "id_echantillon";
                $validationColumn = "validation";
                $dateValidationColumn = "validation";
                $valideurColumn = "valideur";
                $descriptionColumn = "description";
            }

            $query = "SELECT * 
                    FROM 
                        {$nomTypeRapport} 
                    WHERE 
                        {$echantillonColumn} = {$id_echantillon} 
                    ORDER BY 
                        {$revisionColumn} DESC LIMIT 1";

            $db->setQuery($query);

            $result = $db->loadObjectList();

            if ($db->getErrorNum()) {
                echo $db->getErrorMsg();
                exit;
            }

            if (count($result) > 0) {
                return $result;
            }
        }
        return $result;
    }
}
