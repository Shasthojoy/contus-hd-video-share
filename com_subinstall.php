<?php

/**
 * @version     2.2, Creation Date : March-24-2011
 * @name        hdvideoshareinstall.php
 * @location    administrator/components/com_contushdvideoshare/com_subinstall.php
 * @package	Joomla 1.6
 * @subpackage	contushdvideoshare
 * @author      Contus Support - http://www.contussupport.com
 * @copyright   Copyright (C) 2011 Contus Support
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link        http://www.hdvideoshare.net
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Include the actual subinstaller class
require_once dirname(__FILE__) . '/subinstall.php';

/**
 * API entry point. Called from main installer.
 */
function com_install() {
    $si = new SubInstaller();
    $ret = $si->install();
    if ($ret) {
        // Install success. Joomla's module installer
        // creates an additional module instance during
        // upgrade. This seems to confuse users, so
        // let's remove that now.
        $minst = & JInstaller::getInstance();
        $db = & $minst->getDBO();
        /*  query to find the componen if already exist or not */
        $query = 'SELECT COUNT(id) as n FROM #__modules
                  WHERE module = "mod_HDVideoSharePopular"';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        /* if already exist then  condition will be execute */
        if ($n > 1) {
            /*  query to select the id to founded module */
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoSharePopular" AND title = "Popular Videos" and published = 0
                      ORDER BY id DESC
                      LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                /* remove the modele from database */
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }

        $query = 'SELECT COUNT(id) as n FROM #__modules
                          WHERE module = "mod_HDVideoShareSearch"';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoShareSearch" AND title = "Search Videos" and published = 0
                      ORDER BY id DESC
                      LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }
        $query = 'SELECT COUNT(id) as n FROM #__modules
                          WHERE module = "mod_HDVideoShareRecent"';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoShareRecent" AND title = "Recent Videos" and published = 0
                      ORDER BY id DESC LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }
        $query = 'SELECT COUNT(id) as n FROM #__modules
                          WHERE module = "mod_HDVideoShareFeatured"';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoShareFeatured" AND title = "Featured Videos" and published = 0
                      ORDER BY id DESC
                      LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }
        $query = 'SELECT COUNT(id) as n FROM #__modules
                          WHERE module = "mod_HDVideoShareRelated';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoShareRelated" AND title = "Related Videos" and published = 0
                      ORDER BY id DESC
                      LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }
        $query = 'SELECT COUNT(id) as n FROM #__modules
                          WHERE module = "mod_HDVideoShareCategories"';
        $db->setQuery($query);
        $db->query();
        $n = $db->loadResult();
        if ($n > 1) {
            $query = 'SELECT id FROM #__modules
                      WHERE module = "mod_HDVideoShareCategories" AND title = "Video Category" and published = 0
                      ORDER BY id DESC
                      LIMIT 1';
            $db->setQuery($query);
            $db->query();
            $m = $db->loadResult();
            if ($m) {
                $query = 'DELETE FROM #__modules_menu
                          WHERE moduleid = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
                $query = 'DELETE FROM #__modules
                          WHERE id = ' . (int) $m;
                $db->setQuery($query);
                $db->query();
            }
        }
    }
    $assets = JURI::root() . '/administrator/components/com_contushdvideoshare/assets/';
    $assetsPath = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_contushdvideoshare' . DS . 'assets' . DS;
    $lang = & JFactory::getLanguage();
    $welcome = $assetsPath . $lang->getTag() . '.welcome.html';
    if (!file_exists($welcome)) {
        $welcome = $assetsPath . 'en-GB.welcome.html';
    }
    /* welcome message after install the component */
    echo '<table width="100%"><tr><td>' . file_get_contents($welcome) . '</td></tr></table>';
    echo '<table width="100%"><tr><td><div style="float:left;width:20%;padding-top:8px;"><img src="' . $assets . 'customization_contushdvideoshare.jpg" alt="" /></div><div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;">
          Do you know that ContusHDVideoShare not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
          </div><div style="float:right;padding-top:8px;text-decoration:underline;"><div><img src="' . $assets . 'logo.jpg" alt="" /></div><div> <div style="padding: 8px 0pt 0pt 10px;float:left;"> <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a></div><div style="padding: 8px 0pt 0pt 10px;float:left;"><a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a></div></div></div></td>
          </tr></table>';

    // Workaround for a silly behavior of Joomla's extension installer which issues warnings for
    // every skipped language file. Support experience showed that this scares off most newbies making
    // them think that the install went wrong.
    // We collect these messages and replace them by a single informational message.
    $app = & JFactory::getApplication();
    $name = JText::_($app->getName());
    $warnregex = JText::sprintf('INSTALLER LANG NOT INSTALLED',
                    '([a-z][a-z]-[A-Z][A-Z]\..*?\.ini)', $name, '([a-z][a-z]-[A-Z][A-Z])');
    $oqueue = & $app->getMessageQueue();
    $nqueue = array();
    $installingFileSkipped = '';
    foreach ($oqueue as $msg) {
        if ($msg['type'] == 'notice') {
            $matches = array();
            if (preg_match('#' . $warnregex . '#', $msg['message'], $matches)) {
                if (count($matches) == 3) {
                    $errorTagMatching = $matches[2];
                    // failing to install en-GB is still serious
                    if ($errorTagMatching != 'en-GB') {
                        if (strpos($installingFileSkipped, $errorTagMatching) === false) {
                            if (!empty($installingFileSkipped)) {
                                $installingFileSkipped .= ', ';
                            }
                            $installingFileSkipped .= "'" . $errorTagMatching . "'";
                        }
                        continue;
                    }
                }
            }
        }
        $nqueue[] = $msg;
    }
    $app->_messageQueue = $nqueue;
    if (!empty($installingFileSkipped)) {
        $installingFileSkipped = preg_replace('#,( [^,]+)$#', ' and$1', $installingFileSkipped);
        $app->enqueueMessage('Note: Language files for the languages ' . $installingFileSkipped . ' have been skipped.');
    }
}

/**
 * API entry point. Called from main un installer.
 */
function com_uninstall() {
    $si = new SubInstaller();
    return $si->uninstall();
}
