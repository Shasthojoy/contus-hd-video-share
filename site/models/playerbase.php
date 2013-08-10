<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Playerbase Model
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla model library
jimport( 'joomla.application.component.model' );
/**
 * Contushdvideoshare Component Playerbase Model
 */
class Modelcontushdvideoshareplayerbase extends JModel
{
   /* function to get player skin */
    function playerskin()
    {
        $playerpath = JURI::base().'components/com_contushdvideoshare/hdflvplayer/hdplayer.swf';
        $this->showplayer($playerpath);       
    }

    function showplayer($playerpath)
    {       
        ob_clean();
        header("content-type:application/x-shockwave-flash");
        readfile($playerpath);
        exit();        
    }
}