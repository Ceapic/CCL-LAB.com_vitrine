<?php
defined('_JEXEC') or die;

class lepbiViewlepbi extends JViewLegacy
{
    protected $adminMessage;

    public function display($tpl = null)
    {
        // Get data from the model
        $this->adminMessage = $this->get('AdminMessage');
        parent::display($tpl);
    }
}
?>
