<?php
defined('_JEXEC') or die;

class HelloworldModelHelloworld extends JModelItem
{
    // A simple function to return an admin message
    public function getAdminMessage()
    {
        return 'Hello from the administrator side!';
    }
}
?>
