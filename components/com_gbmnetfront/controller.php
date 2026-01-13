<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class GbmnetfrontController extends JControllerLegacy {

    function CheckTokenFront() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        echo Gbmnetfront::CheckLocalToken($token);
    }

    function ListeStrategieChantierFront() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');
        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');
        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        global $mainframe;
        // $model = $this->getModel('gbmnetworldFront');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        // md5($id_client . $type_client . $sharingkey)
        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=ListeStrategieChantierBack&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }


    function SuiviStrategieLoaderFront() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        // $id_echantillon = JRequest::getVar('id_echantillon');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_strategie = $input->get('id_strategie', '', 'int');

        // $ref_strategie = JRequest::getVar('ref_strategie');
        $ref_strategie = $input->get('ref_strategie', '', 'int');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        // var_dump("laaaaaaaa2");
        // md5($id_client . $type_client . $sharingkey)
        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            // var_dump($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=SuiviStrategieLoader&id_echantillon=" . $id_echantillon . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
            echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=SuiviStrategieLoaderBack&id_echantillon=" . $id_echantillon . "&id_strategie=" . $id_strategie . "&ref_strategie=" . $ref_strategie . "&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }

    function ListeRapportChantierFront() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');
        global $mainframe;

        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        // md5($id_client . $type_client . $sharingkey)
        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=ListeRapportChantierBack&id_chantier=" . $id_chantier . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }


    function AfficheRapportFront() {
        $app = JFactory::getApplication();
        $input = $app->input;
        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $id_echantillon = JRequest::getVar('id_echantillon');
        $id_echantillon = $input->get('id_echantillon', '', 'int');

        $id_rapport = $input->get('id_rapport', '', 'int');
        $tokenrapport = $input->get('tokenrapport', '', 'string');
        $ref = $input->get('ref', '', 'string');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        //md5($id_client . $type_client . $sharingkey)
        if ((555 == $tokenclient) && (md5($id_rapport . $sharingkey) == $tokenrapport)) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=AfficheRapportBack&id_echantillon=" . $id_echantillon . "&id_rapport=" . $id_rapport . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

            $pdf = file_get_contents($url);
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
            ob_clean();
            flush();
            echo $pdf;
        }
    }

    function AfficheRapportEchantillonFront() {
        $app = JFactory::getApplication();
        $input = $app->input;
        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        $id_mission = $input->get('id_mission', '', 'int');
        $tokenMission = $input->get('tokenMission', '', 'string');

        $id_echantillon = $input->get('id_echantillon', '', 'int');
        $tokenEchantillon = $input->get('tokenEchantillon', '', 'string');

        $ref = $input->get('ref', '', 'string');
        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        //md5($id_client . $type_client . $sharingkey)
        if (
            (555 == $tokenclient) &&
            ((md5($id_echantillon . $sharingkey) == $tokenEchantillon) || (md5($id_mission . $sharingkey) == $tokenMission))
        ) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=AfficheRapportEchantillon&id_echantillon={$id_echantillon}&id_mission={$id_mission}&id_client={$id_client}&token={$token}&format=raw";

            $pdf = file_get_contents($url);
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
            ob_clean();
            flush();
            echo $pdf;
        }/* else {
			var_dump(md5($id_client . $type_client . $sharingkey));
			var_dump($tokenClient);
			var_dump(md5($id_echantillon . $sharingkey));
			var_dump($tokenEchantillon);
			var_dump(md5($id_mission . $sharingkey));
			var_dump($tokenMission);
			var_dump("Erreur de sécurité");
		}*/
    }
    function DownloadAllRapportChantierFront() {
        $app = JFactory::getApplication();
        $input = $app->input;

        $id_client = $input->get('id_client', '', 'int');
        $type_client = $input->get('type_client', '', 'int');
        $tokenclient = $input->get('tokenclient', '', 'string');
        $id_chantier = $input->get('id_chantier', '', 'int');
        $ref_chantier = $input->get('ref_chantier', '', 'string');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        //md5($id_client . $type_client . $sharingkey)
        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=DownloadAllRapportChantierBack&id_chantier=" . $id_chantier . "&type_rapport=" . $type_client . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

            $pdf = file_get_contents($url);
            header('Content-Disposition: attachment; filename=RapportsChantier_' . $ref_chantier . '.zip');
            ob_clean();
            flush();
            echo $pdf;
        }
    }


    ////////////////////////////////////////////  TelechargeStrategie  ///////////////////////////////////////////
    function AfficheStrategieFront() {
        $app = JFactory::getApplication();
        $input = $app->input;
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_strategie = $input->get('id_strategie', '', 'int');

        // $type_strategie = JRequest::getVar('type_strategie');
        $type_strategie = $input->get('type_strategie', '', 'int');

        // $ref = JRequest::getVar('ref');
        $ref = $input->get('ref', '', 'string');
        global $mainframe;
        // $model = $this->getModel('ceapicworld'); nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        //md5($id_client . $type_client . $sharingkey)
        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=AfficheStrategie&id_strategie=" . $id_strategie . "&type_strategie=" . $type_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

            $pdf = file_get_contents($url);
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename=' . str_replace("*", "", $ref) . '.pdf');
            ob_clean();
            flush();
            echo $pdf;
        }
    }

    ////////////////////////////////////////////////// commander /////////////////////////////////////////////////////

    function CommanderFront() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');
        $id_echantillon = $input->get('id_echantillon', '', 'string');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        //md5($id_client . $type_client . $sharingkey)

        if (555 == $tokenclient) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            var_dump($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=CommanderBack&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
            echo file_get_contents($model->GetRemoteToken() . "/index.php?option=com_lepbi&task=CommanderBack&id_echantillon=" . $id_echantillon . "&id_client=" . $id_client . "&token=" . $token . "&format=raw");
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }


    ///////////////////////////////////////////////// Extraction ////////////////////////////////////////////////////////////
    function ExtractionFront() {
        $app = JFactory::getApplication();
        $input = $app->input;
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_chantier = JRequest::getVar('id_chantier');
        $id_chantier = $input->get('id_chantier', '', 'int');

        // $date_debut = JRequest::getVar('debut_extraction');
        $date_debut = $input->get('date_debut', '', 'date');

        // $date_fin = JRequest::getVar('fin_extraction');
        $date_fin = $input->get('date_fin', '', 'date');

        // $tokenchantier = JRequest::getVar('tokenchantier');
        $tokenchantier = $input->get('tokenchantier', '', 'string');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();

        $date_extract = date("Y-m-d H-i");
        //md5($id_client . $type_client . $sharingkey)
        if ((555 == $tokenclient) && (md5($id_chantier . $type_client . $sharingkey) == $tokenchantier) && ($id_chantier <> "0")) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=ExtractionBack&id_chantier=" . $id_chantier . "&date_debut=" . $date_debut . "&date_fin=" . $date_fin . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

            $excel = file_get_contents($url);

            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment; filename="Extraction-' . $date_extract . '.xlsx"');
            ob_clean();
            flush();
            echo $excel;
        }
    }

    ///////////////////////////////////////////////////// BonCommande /////////////////////////////////////////////////////////
    function BonCommandeFront() {
        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        // $id_client = JRequest::getVar('id_client');
        $id_client = $input->get('id_client', '', 'int');

        // $type_client = JRequest::getVar('type_client');
        $type_client = $input->get('type_client', '', 'int');

        // $tokenclient = JRequest::getVar('tokenclient');
        $tokenclient = $input->get('tokenclient', '', 'string');

        // $id_strategie = JRequest::getVar('id_strategie');
        $id_strategie = $input->get('id_strategie', '', 'int');

        // $tokenstrategie = JRequest::getVar('tokenstrategie');
        $tokenstrategie = $input->get('tokenstrategie', '', 'int');

        global $mainframe;
        // $model = $this->getModel('ceapicworld');  nom model
        $model = new gbmnetworldFront;
        $sharingkey = $model->GetSharingKey();
        // md5($id_client . $type_client . $sharingkey)
        if ((555 == $tokenclient) && (md5($id_strategie . $sharingkey) == $tokenstrategie)) {
            $token = $model->CreateToken(bin2hex(openssl_random_pseudo_bytes(16)));
            $url = $model->GetRemoteToken() . "/index.php?option=com_lepbi&task=BonCommandeBack&id_strategie=" . $id_strategie . "&id_client=" . $id_client . "&token=" . $token . "&format=raw";

            $excel = file_get_contents($url);
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment; filename=CEAPIC BdC.xlsx');
            ob_clean();
            flush();
            echo $excel;
        } else {
            die('Erreur de s&eacute;curit&eacute;');
        }
    }

    /////////////////////////////////////////////////////////// BACK //////////////////////////////////////////////////////
    function ListeClient() {


        // JRequest::checkToken('GET') or die( 'Invalid Token' );
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', 0, 'int');
        // $token = JRequest::getVar('token');
        // $id_client = JRequest::getVar('id_client');
        global $mainframe;
        $model = new Back(); //$this->getModel('back'); // nom model
        //var_dump($model);
        //die();
        $checktoken = $model->CheckRemoteToken($token);
        // var_dump($checktoken);
        // echo $checktoken;
        // echo "supp";
        // die();
        if ($checktoken == "true" || $checktoken == true) {
            $clients = $model->ListeClient();
            // echo"im the return of the databse";
            echo json_encode($clients);
        } else {
            die('false caus error im controller ListeClient');
        }
    }

    function ListeChantier() {
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');
        $id_client = $input->get('id_client', '', 'int');

        global $mainframe;
        $model = new Back;

        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $chantiers = $model->ListeChantier($id_client);
            echo json_encode($chantiers);
        } else {
            die('false');
        }
    }

    function ListeStrategieChantier() {
        var_dump("la");
        $app = JFactory::getApplication();
        $input = $app->input;
        $token = $input->get('token', '', 'string');

        $id_client = $input->get('id_client', '', 'int');
        $id_chantier = $input->get('id_chantier', '', 'int');
        global $mainframe;
        $model = new Back;
        $checktoken = $model->CheckRemoteToken($token);
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
        $ref_strategie = $input->get('ref_strategie', '', 'int');
        global $mainframe;
        // $model0 = $this->getModel('ceapicworld');  nom model
        $model0 = new Back;
        $checktoken = $model0->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model0->CheckClientChantier($id_client, $id_chantier);
            if ($checkClientChantier == "true") {
                // $model = $this->getModel('strategie');  nom model
                $back = new back();

                // test si strategie_chantier ou strategie_chantier_v1				
                $last_strategie = $back->getTypeLastStrategie($id_echantillon);
                //$id_strategie = $last_strategie->id_strategie;
                $type_strategie = $last_strategie->type_strategie;
                if ($type_strategie == "1") {
                    if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                        include('include/suivi-chantier.php');
                    } else {
                        include('/include/suivi-chantier.php');
                    }
                }

                if ($type_strategie == "2") {
                    if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                        // include('include/suivi-chantier-v1.php');
                    } else {
                        // include('/include/suivi-chantier-v1.php');
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
        $model0 = new back;
        $checktoken = $model0->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $checkClientChantier = $model0->CheckClientChantier($id_client, $id_chantier);

            if ($checkClientChantier == "true") {
                // $model = $this->getModel('strategie'); // nom model
                $model = new strategie;
                // $model2 = $this->getModel('synthese'); // nom model
                $model2 = new synthese;
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
        $model = new back;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);
            if ($CheckClientEchantillon == "true") {
                $Rapport = $model->AfficheRapport($id_echantillon, $id_rapport);
                $oneRapport = $Rapport[0];

                $type_rapport = str_replace('é', 'e', $oneRapport->nom_qualification);
                if (($oneRapport->nom_methode_prelevement == "NF X 43-050") || ($oneRapport->nom_methode_prelevement == "XP X 43-269"))
                    $type_rapport = $type_rapport . " " . $oneRapport->nom_methode_prelevement;

                $file = str_replace(" ", "%20", "http://localhost/CEAPIC/Rapport/" . $oneRapport->nom_client . "/" . str_replace("/", "-", $oneRapport->nom_chantier) . "/" . $type_rapport . "/" . $oneRapport->ref_echantillon . "-v" . $oneRapport->revision . ".pdf");
                echo "hello";
                var_dump($file);
                die();
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
        $model = new back;
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
        $model = new back;
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
                        echo file_get_contents($PathFile);
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


    ////////////////////////////////////////////  TelechargeStrategie  ///////////////////////////////////////////

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
        $model = new back;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {
            $checkClientStrategie = $model->CheckClientStrategie($id_client, $id_strategie);
            if ($checkClientStrategie == "true") {
                if ($type_strategie == 1) {
                    $Strategies = $model->AfficheStrategie($id_strategie, $type_strategie);
                    $oneStrategie = $Strategies[0];

                    $file = str_replace(" ", "%20", "CEAPIC/Rapport/" . $oneStrategie->nom_client . "/" . str_replace("/", "-", $oneStrategie->nom_chantier) . "/" . $oneStrategie->nom_qualification . "/" . $oneStrategie->ref_echantillon . "-v" . $oneStrategie->revision_strategie_chantier . ".pdf");
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

    //////////////////////////////////////////////////////// commander //////////////////////////////////////////////////
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
        $model = new back;
        $model0 = new Strategie;
        $checktoken = $model->CheckRemoteToken($token);
        if ($checktoken == "true" || $checktoken == true) {
            $CheckClientEchantillon = $model->CheckClientEchantillon($id_client, $id_echantillon);
            if ($CheckClientEchantillon == "true") {
                if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                    include('include/commander.php');
                } else {
                    include('include/commander.php');
                    echo "hello";
                    die();
                }
            } else {
                die('false');
            }
        } else {
            die('false');
        }
    }

    //////////////////////////////////////////////////// Extraction ///////////////////////////////////////////////////////
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
        $model = new back;
        $checktoken = $model->CheckRemoteToken($token);

        if ($checktoken == "true" || $checktoken == true) {

            $checkClientChantier = $model->CheckClientChantier($id_client, $id_chantier);
            if (($checkClientChantier == "true") || ($id_chantier == "0")) {
                require_once '/../../libraries/phpexcel/PHPExcel/IOFactory.php';

                if ((strtolower(PHP_OS) == "linux") || (strtolower(PHP_OS) == "superior operating system")) {
                    include('include/extraction.php');
                } else {
                    include('include/extraction.php');
                }
                echo "";
                // echo file_get_contents($file);
            } else {
                die('Erreur de s&eacute;curit&eacute;');
            }
        } else {
            die('Token invalide');
        }
    }
}
