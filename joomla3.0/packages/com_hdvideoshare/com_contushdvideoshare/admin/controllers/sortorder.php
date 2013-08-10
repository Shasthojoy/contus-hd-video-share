<?php
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share Component Sortorder Controller
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * hdvideoshare component sortorder administrator controller
 */
class contushdvideoshareControllersortorder extends JControllerAdmin
{

	// function to use sortorder in videos grid
    function display($cachable = false, $urlparams = false) {
        $view = $this->getView('sortorder');
        // Get/Create the model
        if ($model = $this->getModel('sortorder')) {
            $view->setModel($model, true);
        }
        $view->setLayout('sortorderlayout');
        $task= JRequest::getVar( 'task', 'get' , '', 'string' );
		if($task=='videos')
        $view->videosortorder(); 
		else
		$view->categorysortorder();		
    }
}
?>
