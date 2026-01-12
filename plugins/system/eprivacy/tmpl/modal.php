<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.eprivacy
 *
 * @copyright   (C) 2007 Michael Richey. <https://www.richeyweb.com>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
use Joomla\CMS\Language\Text;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects
?>
<div class="modal" id="plg_system_eprivacy_modal" tabindex="-1" aria-labelledby="plg_system_eprivacy_modal_label" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="plg_system_eprivacy_modal_label"><?php echo Text::_('PLG_SYSTEM_EPRIVACY_TITLE');?></h5>
      </div>
      <div class="modal-body">
        <p class="text-center"><span class="fa-stack fa-2x mx-auto d-none d-lg-block"><i class="fas fa-shield fa-stack-2x text-dark"></i><i class="fas fa-user fa-stack-1x text-light"></i></span></p>
        <p><?php echo Text::_('PLG_SYSTEM_EPRIVACY_MESSAGE');?></p>
        <div class="accordion accordion-flush" id="plg_system_eprivacy_details">
            <div class="accordion-item">
                <div class="accordion-header" id="plg_system_eprivacy_details_header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#plg_system_eprivacy_details_content" aria-expanded="false" aria-controls="plg_system_eprivacy_details_content">Details</button>
                </div>
                <div class="accordion-collapse collapse" id="plg_system_eprivacy_details_content" aria-labelledby="plg_system_eprivacy_details_header" data-bs-parent="#plg_system_eprivacy_details">
                    <div class="accordion-body">
                        <?php foreach((array)$scriptOptions as $plugin => $options) : ?>
                            <?php if($plugin === 'plg_system_eprivacy') : continue; endif; ?>
                            <h6><?php echo Text::_($plugin.'_SCRIPT');?></h6>
                            <ul class="list-unstyled">
                                <?php foreach(array_keys($options['consent']) as $option) : ?>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?php echo $plugin.'-'.$option;?>" data-option="<?php echo $option;?>" data-plugin="<?php echo $plugin;?>">
                                        <label class="form-check-label" for="<?php echo $plugin.'-'.$option;?>"><?php echo Text::_(strtoupper($plugin).'_SCRIPT_'.strtoupper($option));?><i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo Text::_(strtoupper($plugin).'_SCRIPT_'.strtoupper($option).'_DESC');?>"></i></label>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger decline"><?php echo Text::_('PLG_SYSTEM_EPRIVACY_DECLINE');?></button>
        <button type="button" class="btn btn-success accept"><?php echo Text::_('PLG_SYSTEM_EPRIVACY_ACCEPT');?></button>
      </div>
    </div>
  </div>
</div>