<?php


// require_once(JPATH_COMPONENT . DS . 'models/global.php');
require_once(URL_MODELE . "global.php");

class ProcessusClient
{

    public $id;
    public $id_client;
    public $reference_client;
    public $texte;
    public $protection_humidification;
    public $protection_captage;
    public $disable;


    static function listProcessusClient()
    {
        $where = "";
        /*if ($type != null) {
            $where = 'WHERE type = ' . $type;
        }*/

        $req = "SELECT 
                pc.*,                
                CONCAT('C',LPAD(client.ref_client,3,0),' ',client.nom_client) as client,
                CONCAT(
                    if(pt.type =1 ,'(Manuel) ','(Mécanique) '),
                    GROUP_CONCAT(CONVERT(pt.nom USING utf8mb4))
                )as techniques
            FROM 
                processus_client pc
            INNER JOIN client                           ON pc.id_client = client.id_client
            INNER JOIN processus_client_technique pct   ON pct.id_processus_client = pc.id
            INNER JOIN processus_technique pt           ON pt.id = pct.id_processus_technique            
                                   
            " . $where . "
    
            GROUP BY 
                pc.id

            ORDER BY
                client.ref_client,
                pc.reference_client  ";
        $GLOBALS["DB"]->setQuery($req);
        // var_dump($req);
        // die();
        if ($GLOBALS["DB"]->getErrorNum()) {
            echo $GLOBALS["DB"]->getErrorMsg();
            exit;
        }
        return $GLOBALS["DB"]->loadObjectList();
    }

    static function getById($idProcessus)
    {
        $db = &GBMNet::getDBOGBMNet();
        $req = "SELECT 
                pc.*,
                if(pt.type = '1','Manuel','Mecanique')              AS type,                 
                GROUP_CONCAT(distinct pt.nom)                       AS technique,
                GROUP_CONCAT(distinct mmm.nom)                      AS materiaux,                
                GROUP_CONCAT(pt.id)                                 AS idTechniques,                 
                GROUP_CONCAT(mmm.id)                                AS idMateriaux,                
                pt.type                                             AS typeTechnique,

                pc.protection_humidification                        AS humiString,

                pc.protection_captage                               AS captaString

            FROM 
                processus_client pc
            LEFT JOIN processus_client_technique pct   ON pct.id_processus_client = pc.id
            LEFT JOIN processus_technique pt           ON pt.id = pct.id_processus_technique
            LEFT JOIN processus_client_mpca pcm        ON pcm.id_processus_client = pc.id
            LEFT JOIN mpca_matrice_materiau mmm        ON mmm.id = pcm.id_mpca_materiau

            WHERE
                pc.id = " . $idProcessus . " 
            
            GROUP BY 
                pc.id";

        // echo "global";
        // var_dump($GLOBALS['DB']);
        // var_dump(GBMNet::getDBOGBMNet());
        // die();
        // $db->setQuery($req);
        $GLOBALS["DB"]->setQuery($req);

        // $resultat = $db->loadObject();
        $resultat = $GLOBALS["DB"]->loadObject();
        if ($resultat) {
            $resultat->protection_humidification =  Tools::decodeCaracteres(str_replace(array('[', ']', '"'), '', $resultat->protection_humidification));
            $resultat->protection_captage =  Tools::decodeCaracteres(str_replace(array('[', ']', '"'), '', $resultat->protection_captage));

            return $resultat;
        } else {
            return null;
        }
    }

    static function listProcessusClientByClient($id_client, $show_disable = false)
    {

        $req = "SELECT 
                pc.*,                
                CONCAT('C',LPAD(client.ref_client,3,0),' ',client.nom_client) as client,
                CONCAT(
                    if(pt.type =1 ,'(Manuel) ','(Mécanique) '),
                    GROUP_CONCAT(CONVERT(pt.nom USING utf8mb4))
                )as techniques
            FROM 
                processus_client pc
            INNER JOIN client                           ON pc.id_client = client.id_client
            INNER JOIN processus_client_technique pct   ON pct.id_processus_client = pc.id
            INNER JOIN processus_technique pt           ON pt.id = pct.id_processus_technique            
                                   
            WHERE 
                pc.id_client = {$id_client}
                
    
            GROUP BY 
                pc.id

            ORDER BY
                client.ref_client,
                pc.reference_client ";
        $GLOBALS["DB"]->setQuery($req);

        if ($GLOBALS["DB"]->getErrorNum()) {
            echo $GLOBALS["DB"]->getErrorMsg();
            exit;
        }
        return $GLOBALS["DB"]->loadObjectList();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id_client
     */
    public function getId_client()
    {
        return $this->id_client;
    }

    /**
     * Set the value of id_client
     *
     * @return  self
     */
    public function setId_client($id_client)
    {
        $this->id_client = $id_client;

        return $this;
    }

    /**
     * Get the value of reference_client
     */
    public function getReference_client()
    {
        return $this->reference_client;
    }

    /**
     * Set the value of reference_client
     *
     * @return  self
     */
    public function setReference_client($reference_client)
    {
        $this->reference_client = $reference_client;

        return $this;
    }

    /**
     * Get the value of disable
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Set the value of disable
     *
     * @return  self
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;

        return $this;
    }

    /**
     * Get the value of protection_humidification
     */
    public function getProtection_humidification()
    {
        return $this->protection_humidification;
    }

    /**
     * Set the value of protection_humidification
     *
     * @return  self
     */
    public function setProtection_humidification($protection_humidification)
    {
        $this->protection_humidification = $protection_humidification;

        return $this;
    }

    /**
     * Get the value of protection_captage
     */
    public function getProtection_captage()
    {
        return $this->protection_captage;
    }

    /**
     * Set the value of protection_captage
     *
     * @return  self
     */
    public function setProtection_captage($protection_captage)
    {
        $this->protection_captage = $protection_captage;

        return $this;
    }
}

class ProcessusClientTechnique
{
    public $id;
    public $id_processus_client;
    public $id_processus_technique;

    public function setProcessusClientTechnique(
        $id_processus_client,
        $id_processus_technique
    ) {
        $this->id_processus_client = $id_processus_client;
        $this->id_processus_technique = $id_processus_technique;
    }

    static function getProcessusClientTechniqueByIDProcessusClient($idProcessusClient)
    {
        $req = 'SELECT 
            *           
        FROM
            processus_client_technique         
        WHERE 
            id_processus_client = ' . $idProcessusClient;

        $GLOBALS["DB"]->setQuery($req);

        if ($GLOBALS["DB"]->getErrorNum()) {
            echo $GLOBALS["DB"]->getErrorMsg();
            exit;
        }
        return $GLOBALS["DB"]->loadObjectList();
    }
}

class ProcessusClientMPCA
{
    public $id;
    public $id_processus_client;
    public $id_mpca_materiau;

    public function setProcessusClientMPCA(
        $id_processus_client,
        $id_mpca_materiau
    ) {
        $this->id_processus_client = $id_processus_client;
        $this->id_mpca_materiau = $id_mpca_materiau;
    }

    static function getProcessusClientMPCA($idProcessusClient)
    {
        $req = 'SELECT 
            *           
        FROM
            processus_client_mpca         
        WHERE 
            id_processus_client = ' . $idProcessusClient;

        $GLOBALS["DB"]->setQuery($req);

        if ($GLOBALS["DB"]->getErrorNum()) {
            echo $GLOBALS["DB"]->getErrorMsg();
            exit;
        }
        return $GLOBALS["DB"]->loadObjectList();
    }

    /**
     * Get the value of texte
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set the value of texte
     *
     * @return  self
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }
}
