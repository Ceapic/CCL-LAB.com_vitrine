<?php

/**
 * Modified Joomla Menu Layout with Dropdown on Hover (Desktop)
 * and Click-to-Toggle on Mobile without using "dropdown-menu" class.
 */
defined('_JEXEC') or die;

$id = '';
if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}
?>
<style>
    /* Desktop Dropdown Styling */
    #desktop li.parent.dropdown {
        position: relative;
    }

    #desktop li.parent.dropdown>ul.nav-child {
        display: none;
        position: absolute;
        left: 0;
        top: 100%;
        /* places the submenu directly below the parent */
        background-color: #fff;
        width: 120px;
        z-index: 1000;
        padding: 0;
        margin: 0;
        list-style: none;
        /* border-collapse: collapse; */
    }

    /* Show submenu on hover :hover*/
    #desktop li.parent.dropdown:hover>ul.nav-child {
        display: block;
        /* width: inherit; */
        /* background: none; */
    }

    #desktop li.parent.dropdown>ul.nav-child>li {
        /* box-sizing: border-box; */
        display: block;
        /* width: 115%;
        border: 5px solid #ccc; */
        /* padding: 10px; */
        margin-bottom: -5px;
        /* border: 1px solid #ccc; */
    }

    #desktop li.parent.dropdown>ul.nav-child>li>a {
        display: block;
        width: 121%;
        /* margin-bottom: 5px; */
        /* padding: 2px 10px; */
        border: 5px solid #ccc;
        box-sizing: border-box;
    }

    /* Mobile Dropdown Styling */
    #mobile ul.nav-child {
        display: none;
        list-style: none;
        padding-left: 15px;
        /* indent for submenu items */
    }

    .submenu-toggle {
        cursor: pointer;
        padding-left: 5px;
        font-size: 0.8em;
    }
</style>
<!-- Desktop Menu -->
<div id="desktop">
    <ul class="nav menu<?php echo $class_sfx; ?> mod-list" <?php echo $id; ?>>
        <?php foreach ($list as $i => &$item) {
            $class = 'item-' . $item->id;
            if ($item->id == $default_id) {
                $class .= ' default';
            }
            if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id)) {
                $class .= ' current';
            }
            if (in_array($item->id, $path)) {
                $class .= ' active';
            } elseif ($item->type === 'alias') {
                $aliasToId = $item->params->get('aliasoptions');
                if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
                    $class .= ' active';
                } elseif (in_array($aliasToId, $path)) {
                    $class .= ' alias-parent-active';
                }
            }
            if ($item->type === 'separator') {
                $class .= ' divider';
            }
            if ($item->deeper) {
                $class .= ' deeper';
            }
            // Mark parent items with a "dropdown" class to help with styling.
            if ($item->parent) {
                $class .= ' parent dropdown';
            }
            echo '<li class="' . $class . '">';

            switch ($item->type):
                case 'separator':
                case 'component':
                case 'heading':
                case 'url':
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                    break;
                default:
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                    break;
            endswitch;

            // If the item is deeper, output the child <ul> using the existing classes.
            if ($item->deeper) {
                echo '<ul class="nav-child unstyled small">';
            } elseif ($item->shallower) {
                echo '</li>';
                echo str_repeat('</ul></li>', $item->level_diff);
            } else {
                echo '</li>';
            }
        } ?>
    </ul>
</div>

<!-- Mobile Menu -->
<div id="mobile">
    <!-- Side navigation container -->
    <div id="mySidenav" class="sidenav">
        <!-- Close button inside the sidenav -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <!-- Joomla Menu Output -->
        <ul class="nav menu<?php echo $class_sfx; ?> mod-list" <?php echo $id; ?>>
            <?php foreach ($list as $i => &$item) {
                $class = 'item-' . $item->id;
                if ($item->id == $default_id) {
                    $class .= ' default';
                }
                if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id)) {
                    $class .= ' current';
                }
                if (in_array($item->id, $path)) {
                    $class .= ' active';
                } elseif ($item->type === 'alias') {
                    $aliasToId = $item->params->get('aliasoptions');
                    if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
                        $class .= ' active';
                    } elseif (in_array($aliasToId, $path)) {
                        $class .= ' alias-parent-active';
                    }
                }
                if ($item->type === 'separator') {
                    $class .= ' divider';
                }
                if ($item->deeper) {
                    $class .= ' deeper';
                }
                if ($item->parent) {
                    $class .= ' parent dropdown';
                }
                echo '<li class="' . $class . '">';
                switch ($item->type):
                    case 'separator':
                    case 'component':
                    case 'heading':
                    case 'url':
                        require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                        break;
                    default:
                        require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                        break;
                endswitch;
                // No extra toggle button – clicking the link toggles the submenu.
                if ($item->deeper) {
                    echo '<ul class="nav-child unstyled small">';
                } elseif ($item->shallower) {
                    echo '</li>';
                    echo str_repeat('</ul></li>', $item->level_diff);
                } else {
                    echo '</li>';
                }
            } ?>
        </ul>
    </div>

    <!-- Hamburger button to open the sidenav -->
    <button onclick="openNav()">&#9776;</button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select each parent list item within the mobile menu that has a submenu
        var parentItems = document.querySelectorAll('#mobile li.parent.dropdown');
        parentItems.forEach(function(item) {
            // Find the link inside the parent item
            var link = item.querySelector('a');
            if (link) {
                link.addEventListener('click', function(e) {
                    // Look for the submenu (ul with class "nav-child") inside the parent li
                    var submenu = item.querySelector('ul.nav-child');
                    if (submenu) {
                        // Toggle the submenu's visibility
                        if (submenu.style.display === "none") {
                            submenu.style.display = "block";
                        } else {
                            submenu.style.display = "none";
                        }
                        // Prevent the link's default navigation behavior
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>