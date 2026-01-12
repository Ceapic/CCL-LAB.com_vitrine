<?php
defined('_JEXEC') or die('Acces interdit');


// require_once(JPATH_COMPONENT . DS . 'models/global.php');
require_once(URL_MODELE . "global.php");

class MPCA {
    public $id;
    public $id_matrice;
    public $nom;
    public $ordre;
    public $disable;

    static function listMatriceMateriauMPCA($avecDesactive = false) {
        if ($avecDesactive) {
            $query = "SELECT 
                mpca_matrice_materiau.id AS id_materiau,
                mpca_matrice_materiau.nom AS nom_materiau,
                mpca_matrice_materiau.id_matrice AS id_matrice,                
                mpca_matrice_materiau.ordre AS ordre_materiau,
                mpca_matrice_materiau.disable AS disable_materiau,
                mpca_matrice.id AS id_matrice,
                mpca_matrice.nom AS nom_matrice,
                mpca_matrice.ordre AS ordre_matrice,
                mpca_matrice.disable AS disable_matrice
            FROM 
                mpca_matrice_materiau
            JOIN mpca_matrice ON mpca_matrice.id = mpca_matrice_materiau.id_matrice
            
            ORDER BY 
                ordre_matrice, 
                ordre_materiau";
        } else {
            $query = "SELECT 
                mpca_matrice_materiau.id AS id_materiau,
                mpca_matrice_materiau.nom AS nom_materiau,
                mpca_matrice_materiau.id_matrice AS id_matrice,
                mpca_matrice_materiau.ordre AS ordre_materiau,
                mpca_matrice_materiau.disable AS disable_materiau,
                mpca_matrice.id AS id_matrice,
                mpca_matrice.nom AS nom_matrice,
                mpca_matrice.ordre AS ordre_matrice,
                mpca_matrice.disable AS disable_matrice
            FROM 
                mpca_matrice_materiau
            JOIN mpca_matrice ON mpca_matrice.id = mpca_matrice_materiau.id_matrice
            WHERE 
                mpca_matrice_materiau.disable = 0
            ORDER BY 
                ordre_matrice, 
                ordre_materiau";
        }
        // die("test");
        JFactory::getDBOGBMNet()->setQuery($query);

        return JFactory::getDBOGBMNet()->loadObjectList();
    }

    static function getMPCAByMatrice($idMatrice) {
        $query = "SELECT 
                mpca_matrice_materiau.id AS id_materiau,
                mpca_matrice_materiau.nom AS nom_materiau,
                mpca_matrice_materiau.id_matrice AS id_matrice,
                mpca_matrice_materiau.ordre AS ordre_materiau,
                mpca_matrice_materiau.disable AS disable_materiau,
                mpca_matrice.id AS id_matrice,
                mpca_matrice.nom AS nom_matrice,
                mpca_matrice.ordre AS ordre_matrice,
                mpca_matrice.disable AS disable_matrice
            FROM 
                mpca_matrice_materiau
            JOIN mpca_matrice ON mpca_matrice.id = mpca_matrice_materiau.id_matrice
            WHERE 
                mpca_matrice_materiau.disable = 0
                AND mpca_matrice_materiau.id_matrice = " . $idMatrice . "
            ORDER BY 
                ordre_matrice, 
                ordre_materiau";


        $GLOBALS["DB"]->setQuery($query);

        return $GLOBALS["DB"]->loadObjectList();
    }

    static function remonteMpca($idMpca) {
        $modele_global = new ModelGlobal;
        $mpca = $modele_global->getItemNew('mpca_matrice_materiau', $idMpca);

        if ($mpca->ordre != 1) {
            $ordreVoulu = $mpca->ordre - 1;
            $query = "SELECT 
				    *
				FROM 
                    mpca_matrice_materiau
				WHERE 
					disable = 0
					AND id_matrice = " . $mpca->id_matrice . "
					AND ordre = " . $ordreVoulu;

            $GLOBALS['DB']->setQuery($query);
            $mpcaDessus = $GLOBALS['DB']->loadObjectList()[0];
            $mpcaDessus->ordre = $mpca->ordre;
            $mpca->ordre = $ordreVoulu;
            $modele_global->editItem('mpca_matrice_materiau', $mpcaDessus, 'id');
            $modele_global->editItem('mpca_matrice_materiau', $mpca, 'id');
            return true;
        }
    }

    static function descendMpca($idMpca) {
        $modele_global = new ModelGlobal;
        $mpca = $modele_global->getItemNew('mpca_matrice_materiau', $idMpca);

        $ordreVoulu = $mpca->ordre + 1;

        if ($ordreVoulu != MPCA::getNextOrdreMPCA($mpca->detail_type_presta_mpca_strategie)) {

            $query = "SELECT 
					*
				FROM 
                    mpca_matrice_materiau	
				WHERE 
					disable = 0
					AND id_matrice = " . $mpca->id_matrice . "
					AND ordre = " . $ordreVoulu;

            $GLOBALS['DB']->setQuery($query);
            $mpcaDessus = $GLOBALS['DB']->loadObjectList()[0];
            $mpcaDessus->ordre = $mpca->ordre;
            $mpca->ordre = $ordreVoulu;
            $modele_global->editItem('mpca_matrice_materiau', $mpcaDessus, 'id');
            $modele_global->editItem('mpca_matrice_materiau', $mpca, 'id');
            return true;
        }
    }


    static function getNextOrdreMPCA($idMatrice) {
        $query = "SELECT 
            MAX(ordre)+1 AS ordre
        FROM 
            mpca_matrice_materiau
        WHERE 
            id_matrice = " . $idMatrice;
        $GLOBALS["DB"]->setQuery($query);
        $res = $GLOBALS["DB"]->loadObjectList();
        return $res[0]->ordre;
    }
}
