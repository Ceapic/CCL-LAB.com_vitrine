<?php
defined('_JEXEC') or die;
const URL_MODELE = "./components/com_gbmnetFront/models/";
// Get an instance of the controller
$controller = JControllerLegacy::getInstance('gbmnetFront');

// Get the task from the request
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>
