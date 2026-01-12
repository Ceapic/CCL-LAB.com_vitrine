<?php
require_once(URL_MODELE . "gbmnetBackModel.php");
// require_once(URL_MODELE . "back.php");
require_once(URL_MODELE . "strategie.php");
require_once(URL_MODELE . "synthese.php");
// require_once(URL_MODELE . "global.php");
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
/**
 * Hello World Component Controller
 *
 * @since  0.0.1
 */
class gbmnetBackController extends JControllerLegacy {
    function ListeClient() {

        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', 0, 'int');
        // $token = JRequest::getVar('token');
        // $id_client = JRequest::getVar('id_client');
        global $mainframe;
        $model = new gbmnetBackModel(); //$this->getModel('back'); // nom model
        //var_dump($model);
        //die();
        $checktoken = $model->CheckRemoteToken($token);
        // var_dump($checktoken);
        // echo $checktoken;
        // echo "supp";
        // die();
        if ($checktoken == "true" || $checktoken == true) {
            $clients = $model->ListeClient();
            // echo "im the return of the databse";
            echo json_encode($clients);
        } else {
            die('false caus error im controller ListeClient');
        }
    }

    function ListeChantier() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        // $token = JRequest::getVar('token');
        // $id_client = JRequest::getVar('id_client');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        // echo "sui?";
        // var_dump($model);
        // die();
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $chantiers = $model->ListeChantier($id_client);
            echo json_encode($chantiers);
        } else {
            die('false');
        }
    }

    function ListeStrategieChantierBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');
        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        // echo $checktoken;
        // die();
        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model->CheckClientChantier($id_client, $id_chantier);
            if ($checkClientChantier == "true") {
                $strategies = $model->ListeStrategieChantier($id_chantier);
                echo json_encode($strategies);
            } else {
                die('false');
            }
        } else {
            die('false');
        }
    }


    function SuiviStrategieLoaderBack() {
        $app = JFactory::getApplication();
        $input = $app->input;
        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        // $id_echantillon = JRequest::getVar('id_echantillon');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_strategie = $input->get('id_strategie', '', 'int');

        // $ref_strategie = JRequest::getVar('ref_strategie');
        $ref_strategie = $input->get('ref_strategie', '', 'string'); //test it was int
        global $mainframe;
        // $model0 = $this->getModel('ceapicworld');  nom model
        $model0 = new gbmnetBackModel;
        $checktoken = $model0->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model0->CheckClientChantier($id_client, $id_chantier);
            if ($checkClientChantier == "true") {
                // $model = $this->getModel('strategie');  nom model
                $back = new gbmnetBackModel();

                // test si strategie_chantier ou strategie_chantier_v1				
                $last_strategie = $back->getTypeLastStrategie($id_echantillon);
                // var_dump($last_strategie);
                //$id_strategie = $last_strategie->id_strategie;
                $type_strategie = $last_strategie->type_strategie;
                if ($type_strategie == "1") {
                    // die($type_strategie);
                    if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                        include('include/suivi-chantier.php');
                    } else {
                        include('include/suivi-chantier.php');
                    }
                }

                if ($type_strategie == "2") {
                    // die($type_strategie);

                    if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                        include('include/suivi-chantier-v1.php');
                    } else {
                        include('include/suivi-chantier-v1.php');
                    }
                }
            } else {
                die('Erreur de s&eacute;curit&eacute;');
            }
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }


    function ListeRapportChantierBack() {

        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        global $mainframe;
        // $model0 = $this->getModel('ceapicworld'); // nom model
        $model0 = new gbmnetBackModel;
        $checktoken = $model0->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model0->CheckClientChantier($id_client, $id_chantier);

            if ($checkClientChantier == "true") {
                // $model = $this->getModel('strategie'); // nom model
                $modelStrategie = new strategie;
                // $model2 = $this->getModel('synthese'); // nom model
                $modelSynthese = new synthese;
                if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                    include('include/liste-rapport.php');
                } else {
                    include('include/liste-rapport.php');
                }
            } else {
                die('false1');
            }
        } else {
            die('false2');
        }
    }

    function AfficheRapportBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');
        // $id_echantillon = JRequest::getVar('id_echantillon');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        $id_rapport = $input->get('id_rapport', '', 'int');


        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);
            if ($CheckClientEchantillon == "true") {
                $Rapport = $model->AfficheRapport($id_echantillon, $id_rapport);
                $oneRapport = $Rapport[0];

                $type_rapport = str_replace('é', 'e', $oneRapport->nom_qualification);
                if (($oneRapport->nom_methode_prelevement == "NF X 43-050") || ($oneRapport->nom_methode_prelevement == "XP X 43-269"))
                    $type_rapport = $type_rapport . " " . $oneRapport->nom_methode_prelevement;

                $config = JFactory::getConfig();
                $filelocation = $config->get('filelocation');
                $file = str_replace(" ", "%20", "http://localhost/$filelocation/Rapport/" . $oneRapport->nom_client . "/" . str_replace("/", "-", $oneRapport->nom_chantier) . "/" . $type_rapport . "/" . $oneRapport->ref_echantillon . "-v" . $oneRapport->revision . ".pdf");
                echo file_get_contents($file);
            }
        } else {
            die('Token invalide');
        }
    }

    function AfficheRapportEchantillonBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;

        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        $id_echantillon = $input->get('id_echantillon', '', 'int');
        $id_mission = $input->get('token', '', 'int');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == true) {
            if ($id_echantillon > 0) {
                $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);

                if ($CheckClientEchantillon == "true") {
                    $Rapport = $model->AfficheRapportEchantillon($id_echantillon);
                    $oneRapport = $Rapport[0];

                    $type_rapport = str_replace('é', 'e', $oneRapport->nom_qualification);
                    //DOIT ON GARDER CES TESTS ? 
                    if (($oneRapport->nom_methode_prelevement == "NF X 43-050") || ($oneRapport->nom_methode_prelevement == "XP X 43-269"))
                        $type_rapport = $type_rapport . " " . $oneRapport->nom_methode_prelevement;

                    $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Rapport/" . $oneRapport->nom_client . "/" . str_replace("/", "-", $oneRapport->nom_chantier) . "/" . $type_rapport . "/" . $oneRapport->ref_echantillon . "-v" . $oneRapport->revision . ".pdf");
                    echo file_get_contents($file);
                } else {
                    var_dump('TOKEN HS');
                }
            }

            if ($id_mission > 0) {
                $RapportFinalMission = $model->RapportFinalClientMission($id_client, $id_mission);
                if ($RapportFinalMission) {
                    $Rapport = $model->AfficheRapportEchantillon($id_echantillon);
                    $oneRapport = $Rapport[0];
                    $type_rapport = str_replace('é', 'e', $oneRapport->nom_qualification);
                    if (($oneRapport->nom_methode_prelevement == "NF X 43-050") || ($oneRapport->nom_methode_prelevement == "XP X 43-269"))
                        $type_rapport = $type_rapport . " " . $oneRapport->nom_methode_prelevement;

                    $file = str_replace(" ", "%20", "http://localhost/{$RapportFinalMission->path}");

                    echo file_get_contents($file);
                } else {
                    echo "existe pas ...";
                }
            }
        } else {
            die('Token invalide');
        }
    }

    function DownloadAllRapportChantierBack() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        $id_chantier = $input->get('id_chantier', '', 'int');
        $type_rapport = $input->get('type_rapport', '', 'int');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model->CheckClientChantier($id_client, $id_chantier);
            if ($checkClientChantier == "true") {

                foreach (scandir('./tmp/') as $oneFile) {
                    $File = explode('_', $oneFile);
                    if ($File[0] == "ZipRapport") {
                        if (date('Ymd') > $File[1])
                            unlink('./tmp/' . $oneFile);
                    }
                }

                foreach ($model->ListeEchantillonChantier($id_chantier) as $oneEchantillon) {
                    foreach ($model->ListeTypeRapport($type_rapport) as $oneTypeRapport) { // liste type de rapport Prélèvement
                        foreach ($model->AfficheLastRevisionRapport($oneEchantillon->id_echantillon, $oneTypeRapport->nom_type_rapport) as $oneRapport) { // Affiche dernier rapport prélèvement
                            $methode = "";
                            if (($oneEchantillon->nom_methode_prelevement == "NF X 43-050") || ($oneEchantillon->nom_methode_prelevement == "XP X 43-269")) {
                                $methode = " " . $oneEchantillon->nom_methode_prelevement;
                            }
                            $link = "CEAPIC\\Rapport\\" . utf8_decode($oneEchantillon->nom_client) . "\\" . str_replace("/", "-", $oneEchantillon->nom_chantier) . "\\" . str_replace('é', 'e', $oneEchantillon->nom_qualification) . $methode . "\\" . $oneEchantillon->ref_echantillon . "-v" . $oneRapport->revision . ".pdf";
                            $linkArray[] = $link . "|" . $oneEchantillon->ref_echantillon . ".pdf";
                        }
                    }
                }
                // Si y a des rapports on génère le ZIP
                if (count($linkArray) > 0) {
                    $zip = new ZipArchive();
                    $filename = "ZipRapport_" . date('Ymd') . "_" . rand(1000, 9999) . ".zip";
                    $PathFile = "./tmp/" . $filename;
                    if ($zip->open($PathFile, ZipArchive::CREATE) !== TRUE) {
                        exit("Impossible d'ouvrir le fichier <$filename>\n");
                    } else {
                        foreach ($linkArray as $oneLink) {
                            $splitLink = explode("|", $oneLink);
                            $zip->addFile($splitLink[0], $splitLink[1]);
                        }

                        $zip->close();
                        echo $PathFile;
                    }
                } else {
                    echo false;
                }
            } else {
                die('Erreur de s&eacute;curit&eacute;');
            }
        } else {
            die('Token invalide');
        }
    }


    //////////////////////////////////////////// mes-chantier  TelechargeStrategie/ Mes-Strategie AfficherStrategie  ///////////////////////////////////////////

    function AfficheStrategieBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;

        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_strategie = $input->get('id_strategie', '', 'int');

        // $type_strategie = JRequest::getVar('type_strategie');
        $type_strategie = $input->get('type_strategie', '', 'int');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        // die("$type_strategie");
        if ($checktoken == "true" || $checktoken == true) {
            $checkClientStrategie = $model->CheckClientStrategie($id_client, $id_strategie);
            if ($checkClientStrategie == "true") {
                if ($type_strategie == 1) {
                    $Strategies = $model->AfficheStrategie($id_strategie, $type_strategie);
                    $oneStrategie = $Strategies[0];

                    $config = JFactory::getConfig();
                    $filelocation = $config->get('filelocation');

                    $file = str_replace(" ", "%20", "$filelocation/Rapport/" . $oneStrategie->nom_client . "/" . str_replace("/", "-", $oneStrategie->nom_chantier) . "/" . $oneStrategie->nom_qualification . "/" . $oneStrategie->ref_echantillon . "-v" . $oneStrategie->revision_strategie_chantier . ".pdf");
                    var_dump($Strategies);
                    die();
                }

                if ($type_strategie == 2) {
                    include_once('models/global.php');
                    $modelGlobal = new ModelGlobal();
                    $oneStrategie = $modelGlobal->getItemNew('strategie_chantier_v1', $id_strategie);
                    $file = $oneStrategie->path;
                }

                echo file_get_contents(str_replace(" ", "%20", "http://localhost/" . $file));
            } else {
                die('Erreur de s&eacute;curit&eacute;');
            }
        } else {
            die('Token invalide');
        }
    }

    //////////////////////////////////////////////////////// mes-chantier commander //////////////////////////////////////////////////
    function CommanderBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;

        // $token = JRequest::getVar('token');
        $token = $input->get('token', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        global $mainframe;
        $model = new gbmnetBackModel;
        $modelStrategie = new Strategie;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);
            if ($CheckClientEchantillon == "true") {
                if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                    include('include/commander.php');
                } else {
                    include('include/commander.php');
                }
            } else {
                die('false');
            }
        } else {
            die('false');
        }
    }

    //////////////////////////////////////////////////// mes-chantier Extraction ///////////////////////////////////////////////////////
    function ExtractionBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');
        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');

        // $date_debut = JRequest::getVar('debut_extraction');
        $date_debut = $input->get('date_debut', '', 'date');

        // $date_fin = JRequest::getVar('fin_extraction');
        $date_fin = $input->get('date_fin', '', 'date');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {

            $checkClientChantier = $model->CheckClientChantier($id_client, $id_chantier);
            if (($checkClientChantier == "true") || ($id_chantier == "0")) {

                require_once 'libraries\phpexcel\PHPExcel\IOFactory.php"';

                if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                    include('include/extraction.php');
                } else {
                    include('include/extraction.php');
                }
                // echo "";
                // echo file_get_contents($file);
            } else {
                die('Erreur de s&eacute;curit&eacute;');
            }
        } else {
            die('Token invalide');
        }
    }

    function AfficheRapportFinalBack() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        $id_rapport = $input->get('id_rapport', '', 'int');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        global $mainframe;
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);
            if ($CheckClientEchantillon == "true") {
                $Rapport = $model->AfficheRapportFinal($id_rapport);
                $oneRapport = $Rapport[0];

                $type_rapport = "Rapport Final";

                $config = JFactory::getConfig();
                $filelocation = $config->get('filelocation');

                $file = str_replace(" ", "%20", "http://localhost/$filelocation/Rapport/" . $oneRapport->nom_client . "/" . str_replace("/", "-", $oneRapport->nom_chantier) . "/" . $type_rapport . "/" . str_replace("VS-", "RF-", $oneRapport->ref_echantillon) . "-v" . $oneRapport->revision_rapport_final . ".pdf");

                echo file_get_contents($file);
            }
        } else {
            die('Token invalide');
        }
    }













    /////////////////////////////////////////////////// mes-strategies /////////////////////////////////////////////////
    function ListeStrategieClient() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');

        global $mainframe;
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            echo json_encode($model->ListeStrategieClient($id_client));
        } else {
            die('false');
        }
    }



    ////////////////////////////////////////////////// mes-processus //////////////////////////////////////////////////////////
    function ListeProcessusClient() {
        // die("sui");
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        global $mainframe;
        $model = new gbmnetBackModel;

        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true") {
            if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                include('include/processus.php');
            } else {
                include('include/processus.php');
            }
        } else {
            die('false');
        }
    }


    /////////////////////////////////////////////// mes-rapport-finaux /////////////////////////////////////////////////////

    function ListeRapportsFinaux() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        global $mainframe;
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                include('include/rapports-finaux.php');
            } else {
                include('include/rapports-finaux.php');
            }
        } else {
            die('false');
        }
    }


    /////////////////////////////////////////// mes-dossier ////////////////////////////////////////////////////////////
    function ListeDossierExterne() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');


        // $date_debut = JRequest::getVar('debut_extraction');
        $date_debut = $input->get('date_debut', '', 'date');

        // $date_fin = JRequest::getVar('fin_extraction');
        $date_fin = $input->get('date_fin', '', 'date');

        global $mainframe;
        // $model = $this->getModel('ceapicworld'); // nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $sharingKey = $model->GetSharingKey();
            $dossiers = $model->ListeDossierExterne($id_client, $date_debut, $date_fin, $sharingKey);
            echo json_encode($dossiers);
        } else {
            die('false');
        }
    }

    ////////////////////////////////////////////////// mes-dossier //////////////////////////////////////////////////////////////
    function AfficheAnalyseEchantillonBack() {
        // die("testing");
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');

        $id_client = $input->get('id_client', '', 'int');

        $typeAnalyse = $input->get('typeAnalyse', '', 'string');
        $id = $input->get('id', '', 'int');
        // $type_multi;
        global $mainframe;
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $Analyses = $model->AfficheAnalyseEchantillon($typeAnalyse, $id, $id_client);
            $oneAnalyse = $Analyses[0];
            // var_dump($id);
            // var_dump($oneAnalyse);
            // die();
            $CheckMulti = 0;
            $file = "";

            if ($typeAnalyse == "multi") {
                $file = $oneAnalyse->path_rapport;
                echo $file;
            } else {

                if ($oneAnalyse->type == "MATERIAU") {
                    // echo"MATERIAU";
                    foreach ($model->SearchAnalyseMateriauMulti($oneAnalyse->id_analyse, $id) as $oneAnalyseMulti) {
                        if ($oneAnalyseMulti->validation_rapport_multi == 1) {
                            $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Analyse/" . $oneAnalyse->nom_client_analyse . "/" . str_replace("/", "-", $oneAnalyse->ref_dossier) . "/" . utf8_decode(str_replace('é', 'e', $oneAnalyse->nom_qualification_analyse)) . "/" . $oneAnalyseMulti->ref_rapport_multi . "-v" . $oneAnalyseMulti->revision_rapport_multi . ".pdf");
                        }
                    }

                    foreach ($model->SearchAnalyseMateriauMultiV0($oneAnalyse->id_analyse, $id) as $oneAnalyseMulti) {
                        if ($oneAnalyseMulti->validation_rapport_multi == 1)
                            $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Analyse/" . $oneAnalyse->nom_client_analyse . "/" . str_replace("/", "-", $oneAnalyse->ref_dossier) . "/" . utf8_decode(str_replace('é', 'e', $oneAnalyse->nom_qualification_analyse)) . "/" . $oneAnalyseMulti->ref_rapport_multi . "-v" . $oneAnalyseMulti->revision_rapport_multi . ".pdf");
                    }
                }
                // die("test");

                if ($oneAnalyse->type == "HAP") {
                    die("HAP");

                    foreach ($model->SearchAnalyseHAPMulti($oneAnalyse->id_analyse, $id) as $oneAnalyseMulti) {
                        if ($oneAnalyseMulti->validation_rapport_multi == 1)
                            $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Analyse/" . $oneAnalyse->nom_client_analyse . "/" . str_replace("/", "-", $oneAnalyse->ref_dossier) . "/" . utf8_decode(str_replace('é', 'e', $oneAnalyse->nom_qualification_analyse)) . "/" . $oneAnalyseMulti->ref_rapport_multi . "-v" . $oneAnalyseMulti->revision_rapport_multi . ".pdf");
                    }
                }

                if ($oneAnalyse->type == "EXOTIQUE_MONO") {
                    die("EXOTIQUE_MONO");

                    $file = $oneAnalyse->path_rapport;
                }

                if ($file == "") {
                    // die("file");
                    $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Analyse/" . $oneAnalyse->nom_client_analyse . "/" . str_replace("/", "-", $oneAnalyse->ref_dossier) . "/" . utf8_decode(str_replace('é', 'e', $oneAnalyse->nom_qualification_analyse)) . "/" . $oneAnalyse->ref_echantillon_analyse . "-v" . $oneAnalyse->revision . ".pdf");
                }
            }
            echo $file;
            echo file_get_contents($file);
        } else {
            // echo "suiiiiiiiiiiiiiiiiiiiiiii";
            die('Token invalide');
        }
    }

    function ExtractionAnalyseDateBack() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $tokenclient = $input->get('tokenclient', '', 'string');
        $id_client = $input->get('id_client', '', 'int');
        $type_client = $input->get('type_client', '', 'int');

        // $date_debut = JRequest::getVar('debut_extraction');
        $date_debut = $input->get('date_debut', '', 'date');
        // var_dump($date_debut);
        // $date_fin = JRequest::getVar('fin_extraction');
        $date_fin = $input->get('date_fin', '', 'date');
        // var_dump($date_fin);
        // die("date");
        $type_extract = $input->get('type_extract', '', 'string');
        global $mainframe;
        // $model = $this->getModel('ceapicworld'); // nom model
        $model = new gbmnetBackModel;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            require_once 'libraries\phpexcel\PHPExcel\IOFactory.php"';

            if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                // die("1");
                include('include/extractionAnalyse' . $type_extract . 'Date.php');
            } else {
                // var_dump($type_extract);
                // die("2");
                include('include/extractionAnalyse' . $type_extract . 'Date.php');
            }

            echo "";
        } else {
            die('Token invalide');
        }
    }
}
