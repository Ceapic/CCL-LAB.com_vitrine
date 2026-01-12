<?php
/**
 *
 * @copyright   Copyright (C)2019 SimpleTools.nl. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;


class PlgSystemSimple_cookie_consent extends JPlugin
{

    private $_insert_html = "0";

    /**
     * Constructor
     *
     * @param object  &$subject The object to observe
     * @param array $config An array that holds the plugin configuration
     *
     * @since   3.9.0
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

    }


    public function onAfterInitialise()
    {
        $app = JFactory::getApplication();

        if ($app->isClient('site')) {
            try{
                $simple_jquery = $this->params->get('simple_jquery', "");
                if ($simple_jquery == 'yes') {
                    JHtml::_('jquery.framework');
                }

                $pluginUrl = JURI::base(true) . '/plugins/system/simple_cookie_consent/';
                $js = $pluginUrl . 'html.js';
                $css = $pluginUrl . 'html.css';

                $link = '<script src="' . $js . '" type="text/javascript"></script>' . "\n";
                $link .= '<link rel="stylesheet" href="' . $css . '" />' . "\n";

                $document = JFactory::getDocument();
                $document->addCustomTag($link);

                $this->_insert_html="1";

            }catch(Exception $e)
            {
                $this->_insert_html="0";
            }
        }
    }


    public function onAfterRender()
    {

        $app = JFactory::getApplication();

        // only insert the script in the frontend
        if ($app->isClient('site')) {

            // retrieve all the response as an html string

            if ($this->_insert_html == "1") {
                $simple_gdpr_cookie_text = $this->params->get('simple_gdpr_cookie_text', "");
                $simple_gdpr_cookie_btn_text = $this->params->get('simple_gdpr_cookie_btn_text', "");


                if ($simple_gdpr_cookie_text != '') {
                    $html_site = $app->getBody();


                    $pluginUrl = JURI::base(true) . '/plugins/system/simple_cookie_consent/';
                    $js = $pluginUrl . 'simple_gdpr/html.js';
                    $css = $pluginUrl . 'simple_gdpr/html.css';


                    JHtml::_('script', $js, array('version' => 'auto', 'relative' => true));
                    JHtml::_('stylesheet', $css, array('version' => 'auto', 'relative' => true));


                    $simple_gdpr_cookie_text = str_replace(array('&lt;', '&gt;', '&quot;'), array('<', '>', '"'), $simple_gdpr_cookie_text);

                    $html = '<div id="simpletools_nl_cookie_notice"  class="cn-bottom bootstrap" aria-label="Cookie Notice">
  <div class="simpletools_nl_cookie_notice-container">
        <span id="cn-notice-text">
            {SIMPLE_TOOLS_NL_GDPR_COOKIE_TEXT}
        </span><button
            id="cn-accept-cookie"
            class="cn-set-cookie cn-button bootstrap button">{SIMPLE_TOOLS_NL_GDPR_COOKIE_BUTTON_TEXT}</button>
  </div>
</div>';


                    $html = str_replace('{SIMPLE_TOOLS_NL_GDPR_COOKIE_TEXT}', $simple_gdpr_cookie_text, $html);
                    $html = str_replace('{SIMPLE_TOOLS_NL_GDPR_COOKIE_BUTTON_TEXT}', $simple_gdpr_cookie_btn_text, $html);


                    $html_site = str_replace('</body>', $html . '</body>', $html_site);

                    // override the original response
                    $app->setBody($html_site);

                }
            }



        }
    }
}
