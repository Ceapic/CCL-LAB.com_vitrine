<?php
defined('_JEXEC') or die ;

use Joomla\CMS\MVC\Controller\BaseController;

class TestController extends BaseController
{
    public function display($cachable = false, $urlparams = array())
    {
        $viewName =$this->input->getCmd('view','test');
        $this->input->set('view',$viewName);

        parent::display($cachable,$urlparams);
    }
}
?>