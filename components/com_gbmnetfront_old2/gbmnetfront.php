<?php
defined('_JEXEC') or die;
const URL_MODELE = "./components/com_gbmnetfront/models/";
// Get an instance of the controller
$controller = JControllerLegacy::getInstance('Gbmnetfront');

// Get the task from the request
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>
