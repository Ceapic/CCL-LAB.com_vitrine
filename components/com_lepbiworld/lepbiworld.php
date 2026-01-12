<?php
defined('_JEXEC') or die('Acces interdit');

// require_once (JPATH_COMPONENT.DS.'controller.php');
// if($controller = JRequest::getWord('controller')) {
// $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
// if (file_exists($path)) {
// require_once $path;
// } else {
// $controller = '';
// }
// }
// $classname	= 'LEPBIWorldController'.ucfirst($controller);
// $controller = new $classname( );
// $controller->execute(JRequest::getCmd('task'));
// $controller->redirect();

$controller = JControllerLegacy::getInstance('LepbiWorld');
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
$controller->redirect();
