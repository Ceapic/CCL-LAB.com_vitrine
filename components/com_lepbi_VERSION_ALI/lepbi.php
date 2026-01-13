<?php
defined('_JEXEC') or die;
?>


<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/jquery/jquery-1.12.4.min.js"></script>
<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/jquery-ui-1.12.1/jquery.ui.datepicker-fr.js"></script>

<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/sheetJS/xlsx.full.min.js"></script>
<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/GBMNET-tab/GBMNET-tab.js"></script>
<script src="<?php echo JURI::root(); ?>components/com_lepbi/js/tools.js"></script>

<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_lepbi/js/jquery-ui-1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_lepbi/js/DataTables/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_lepbi/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_lepbi/js/GBMNET-tab/GBMNET-tab.css">

<?php
const URL_MODELE = "./components/com_lepbi/models/";

require_once(URL_MODELE . "gbmnetfront.php");
require_once(URL_MODELE . "strategie.php");
require_once(URL_MODELE . "synthese.php");


// Get an instance of the controller
$controller = JControllerLegacy::getInstance('lepbi');

$GLOBALS["CBV"] = "com_gbmnetback";
$GLOBALS["GBF"] = new Gbmnetfront();


// $GLOBALS["DB"] = GBMNet::getDBOGBMNet();

// Get the task from the request
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
