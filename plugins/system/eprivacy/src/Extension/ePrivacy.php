<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  System.eprivacy
 *
 * @copyright   (C) 2007 Michael Richey. <https://www.richeyweb.com>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\System\ePrivacy\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\DispatcherInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;


// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Joomla! System Logging Plugin.
 *
 * @since  1.5
 */
final class ePrivacy extends CMSPlugin
{
    protected $app;
    protected $autoloadLanguage = true;

    public function onBeforeCompileHead() 
    {
        // $this->app = $this->getApplication();
        if(!$this->app->isClient('site')) {
            return true;
        }
        $doc = $this->app->getDocument();
        if ($doc->getType() != 'html') {
            return true;
        }
        $debug = $this->app->get('debug', 0)?'' : '.min';
        $this->_wa = $this->app->getDocument()->getWebAssetManager();
        $this->_wa->registerAndUseScript('plg_system_eprivacy', 'media/plg_system_eprivacy/js/eprivacy'.$debug.'.js');

        $options = [
            'display' => $this->params->get('display', 'alert'),
        ];
        $scriptOptions = $doc->getScriptOptions('plg_system_eprivacy',[]);
        $scriptOptions['plg_system_eprivacy'] = $options;
        $doc->addScriptOptions('plg_system_eprivacy', $scriptOptions);


        HtmlHelper::_('bootstrap.tooltip', '.selector', []);
        HtmlHelper::_('bootstrap.collapse');
        switch($options['display']) {
            case 'alert':
                HtmlHelper::_('bootstrap.alert', '.selector');
                Text::script('PLG_SYSTEM_EPRIVACY_TITLE');
                Text::script('PLG_SYSTEM_EPRIVACY_MANDATORY');
                Text::script('PLG_SYSTEM_EPRIVACY_DETAILS');
                Text::script('PLG_SYSTEM_EPRIVACY_MESSAGE');
                Text::script('PLG_SYSTEM_EPRIVACY_AND');
                Text::script('PLG_SYSTEM_EPRIVACY_ACCEPT');
                Text::script('PLG_SYSTEM_EPRIVACY_DECLINE');
                break;
            case 'modal':
                HtmlHelper::_('bootstrap.modal', '.selector', []);
                break;
        }
    }
    public function onAfterRender() {
        // $this->app = $this->getApplication();
        if(!$this->app->isClient('site')) {
            return true;
        }
        $doc = $this->app->getDocument();
        if ($doc->getType() != 'html') {
            return true;
        }
        $display = $this->params->get('display', 'alert');
        switch($display) {
            case 'modal':
                $modal = $this->buildModal();
                $body = $this->app->getBody();
                $body = str_replace('</body>', $modal.'</body>', $body);
                $this->app->setBody($body);
                break;
            case 'alert':
            default:
                break;
        }
    }
    private function buildModal(){
        $params = $this->params;
        $scriptOptions = $this->app->getDocument()->getScriptOptions('plg_system_eprivacy',[]);
        $modal = $this->_loadTemplate('modal', $params, $scriptOptions);
        return $modal;
    }

	private function _loadTemplate($name, $params, $scriptOptions) {
        $path = PluginHelper::getLayoutPath('system', 'eprivacy', $name);
        ob_start();
        include $path;
        $html = ob_get_clean();
        return $html;
	}
}