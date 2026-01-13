<?php
defined('_JEXEC') or die;

class GbmnetfrontViewGbmnetfront extends JViewLegacy {
    protected $message;

    public function display($tpl = null) {
        // Get data from the model
        $this->message = $this->get('HelloMessage');
        parent::display($tpl);
    }
}
