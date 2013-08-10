<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
require_once dirname(__FILE__).'/subinstall.php';
/**
 * API entry point. Called from main installer.
 */
function com_install() {
    $si = new SubInstaller();
    $si->install();
}

/**
 * API entry point. Called from main installer.
 */
function com_uninstall() {
    $si = new SubInstaller();
    $si->uninstall();
}
