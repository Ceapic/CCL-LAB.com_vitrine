<?php
defined('_JEXEC') or die;

class lepbiCntrollerlepbi extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = array())
    {
        // Set the default view if not set
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'helloworld'));
        parent::display($cachable, $urlparams);
        return $this;
    }
}
?>
