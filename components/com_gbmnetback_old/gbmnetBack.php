<?php
defined('_JEXEC') or die;
const URL_MODELE = "./components/com_gbmnetback/models/";
// const URL_excel = "./libraries/phpoffice/phpspreadsheet/src/PhpSpreadsheet";

// Get an instance of the controller
$controller = JControllerLegacy::getInstance('gbmnetBack');

// Get the task from the request
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));



$GLOBALS["DB"] = JFactory::getDBOGBMNet();
$GLOBALS["DB_JML"] = JFactory::getDbo();




// Redirect if set by the controller
$controller->redirect();
?>
