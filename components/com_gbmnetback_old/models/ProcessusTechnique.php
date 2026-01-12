<?php

class ProcessusTechnique {

    const TYPE_MANUEL = 1;
    const TYPE_MECANIQUE = 2;

    public $id;
    public $type;
    public $nom;
    public $ordre;
    public $disable;

    static function listTechnique($type) {
        $where = "";
        if ($type != null) {
            $where = 'WHERE type = ' . $type;
        }

        $req = "SELECT 
                *,                 
                CASE 
                    WHEN type = 1 THEN 'Manuel'
                    WHEN type = 2 THEN 'Mécanique'
                END AS typeStr   
            FROM 
                processus_technique
            " . $where . "

            ORDER BY
                type,
                ordre
            ";
        //var_dump($req);
        JFactory::getDBOGBMNet()->setQuery($req);

        if (JFactory::getDBOGBMNet()->getErrorNum()) {
            echo JFactory::getDBOGBMNet()->getErrorMsg();
            exit;
        }
        return JFactory::getDBOGBMNet()->loadObjectList();
    }

    static function getByTabIdTechnique($tabIdtechnique) {
        $req = "SELECT 
                * 
            FROM 
                processus_technique
            WHERE 
                id IN (" . implode(",", $tabIdtechnique) . ")";

        $GLOBALS['DB']->setQuery($req);
        return $GLOBALS['DB']->loadObjectList();
    }

    static function remonteTechnique($id) {
        $modele_global = new ModelGlobal;
        $tech = $modele_global->getItemNew('processus_technique', $id);

        if ($tech->ordre != 1) {
            $ordreVoulu = $tech->ordre - 1;
            $query = "SELECT 
				    *
				FROM 
                    processus_technique
				WHERE 
                    disable = 0
					AND type = " . $tech->type . "
					AND ordre = " . $ordreVoulu;

            $GLOBALS['DB']->setQuery($query);
            $techDessus = $GLOBALS['DB']->loadObjectList()[0];
            $techDessus->ordre = $tech->ordre;
            $tech->ordre = $ordreVoulu;
            $modele_global->editItem('processus_technique', $techDessus, 'id');
            $modele_global->editItem('processus_technique', $tech, 'id');
            return true;
        }
    }

    static function descendTechnique($id) {
        $modele_global = new ModelGlobal;
        $tech = $modele_global->getItemNew('processus_technique', $id);

        $ordreVoulu = $tech->ordre + 1;

        if ($ordreVoulu != ProcessusTechnique::getNextOrdreProcessustechnique($tech->type)) {

            $query = "SELECT 
					*
				FROM 
                    processus_technique	
				WHERE 
                    disable = 0
					AND type = " . $tech->type . "
					AND ordre = " . $ordreVoulu;

            $GLOBALS['DB']->setQuery($query);
            $techDessus = $GLOBALS['DB']->loadObjectList()[0];
            $techDessus->ordre = $tech->ordre;
            $tech->ordre = $ordreVoulu;
            $modele_global->editItem('processus_technique', $techDessus, 'id');
            $modele_global->editItem('processus_technique', $tech, 'id');
            return true;
        }
    }

    static function getNextOrdreProcessustechnique($type) {
        $query = "SELECT 
            MAX(ordre)+1 AS ordre
        FROM 
            processus_technique
        WHERE 
            type = " . $type;
        JFactory::getDBOGBMNet()->setQuery($query);
        $res = JFactory::getDBOGBMNet()->loadObjectList();
        return $res[0]->ordre;
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }



    /**
     * Get the value of ordre
     */
    public function getOrdre() {
        return $this->ordre;
    }

    /**
     * Set the value of ordre
     *
     * @return  self
     */
    public function setOrdre($ordre) {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get the value of disable
     */
    public function getDisable() {
        return $this->disable;
    }

    /**
     * Set the value of disable
     *
     * @return  self
     */
    public function setDisable($disable) {
        $this->disable = $disable;

        return $this;
    }
}
