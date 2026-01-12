<?php
// phpinfo();
defined('_JEXEC') or die;
const URL_MODELE = "./components/com_gbmnetback/models/";
// const URL_excel = "./libraries/phpoffice/phpspreadsheet/src/PhpSpreadsheet";

// var_dump('toto');
$GLOBALS["DB"] = GBMNet::getDBOGBMNet();
$GLOBALS["DB_JML"] = JFactory::getDbo();
// // var_dump($GLOBALS['DB']);
// die();
// Get an instance of the controller
$controller = JControllerLegacy::getInstance('gbmnetBack');

// Get the task from the request
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// $conf = JFactory::getConfig();
//     $option = array();
//     $option['driver'] = $conf->get('GBMNet_dbtype');        // Database driver name
//     $option['host'] = $conf->get('GBMNet_host');      // Database host name
//     $option['user'] = $conf->get('GBMNet_user');       // User for database authentication
//     $option['password'] = $conf->get('GBMNet_password');   // Password for database authentication
//     $option['database'] = $conf->get('GBMNet_db');   // Database name
//     $option['prefix'] = $conf->get('GBMNet_dbprefix');             // Database prefix
//     //
//     $dbo = & JDatabase::getInstance($option);





// Redirect if set by the controller
$controller->redirect();
?>
